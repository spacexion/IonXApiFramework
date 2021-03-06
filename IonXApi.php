<?php
namespace IonXLab\IonXApi;

use IonXLab\IonXApi\network\ApiRequest;
use IonXLab\IonXApi\network\ApiRequestParser;
use IonXLab\IonXApi\network\ApiResponse;
use IonXLab\IonXApi\routes\ApiRoutes;
use IonXLab\IonXApi\util\EntityMgr;
use IonXLab\IonXApi\util\Util;
use ReflectionMethod;

/**
 * IonX Api Framework<br/>
 * This is the main class of this framework.
 *
 * @author Nicolas Gezequel
 * @version 0.6.0
 *
 * example: api/web/users/1 (get user info from his id)
 * example: api/web/users/1?token=token
 * example: api/web/users (get user list)
 * example: api/web/users?range=10
 * example: api/$project/$object/$id
 * example: api/$project/$object?$parameters
 * example: api/$project/$object/$id/$object2/$id2?$parameters
 */
class IonXApi {

    private static $SUPPORTED_HTTP_METHODS = array("POST"=>"post","GET"=>"get","PUT"=>"put","DELETE"=>"delete");
    private static $SUPPORTED_CONTENT_TYPES = array("application/json"=>"json");

    /**
     * @var \IonXLab\IonXApi\Config
     */
    private $config;
    /**
     * @var ApiRequest
     */
    private $apiRequest;
    /**
     * @var ApiRoutes
     */
    private $apiRoutes;
    /**
     * @var ApiResponse
     */
    private $apiResponse;

    /**
     * @var string
     */
    private $requestProject;
    /**
     * @var string
     */
    private $requestObject;
    /**
     * @var string
     */
    private $requestObjectFullName;
    /**
     * @var string
     */
    private $requestCommand;

    /**
     * @var string
     */
    private $objectManagerFullName;

    /**
     * Default constructor
     */
	public function __construct() {

        $this->config = Config::getInstance();
        $this->apiRoutes = $this->config->getApiRoutes();

        $this->apiResponse = ApiResponse::getInstance();
        $this->apiResponse->setContentType("application/json");
        $this->apiResponse->setStatus(200);

		// We parse the the request
		$requestParser = new ApiRequestParser();
		$this->apiRequest = $requestParser->parse();
	}

    /**
     * Start the api processes and send the built ApiResponse
     */
	public function process() {

        if($this->isValidApiRoutes() && $this->isValidApiRequest()) {

            $updateSchema = false;
            if($this->config->isDevMode()) {
                $updateSchema = $this->updateSchema();
            }
            if(!$this->config->isDevMode() || $updateSchema) {
                $this->execCommand();
            }

            // handle the request by HTTP METHOD

            // parse the body content of request in array if POST or PUT

            // prepare and execute the corresponding command in the manager php class

        }
        // send the ApiResponse
        $this->sendResponse();
	}

    /**
     * Check if ApiRoutes given at constructor is valid
     */
    private function isValidApiRoutes() {

        if($this->apiRoutes==null) {
            $this->apiResponse->setResponseError(500, "Sorry, routes are not defined.");
            return false;
        }

        if(!(gettype($this->apiRoutes)=="object" && get_class($this->apiRoutes)=="IonXLab\\IonXApi\\routes\\ApiRoutes")) {
            $this->apiResponse->setResponseError(500, "Sorry, routes are not of ApiRoutes type.");
            return false;
        }
        return true;
    }

    /**
     * Check if required data are presents and meets the api structure
     */
    private function isValidApiRequest() {

        // check if request has required data
        if(Util::isGoodString($this->apiRequest->getUrl()->getApiProject() == "")) {
            $this->apiResponse->setResponseError(400, "Sorry, you must give project.");
            return false;
        }
        if(Util::isGoodString($this->apiRequest->getUrl()->getApiObject() == "")) {
            $this->apiResponse->setResponseError(400, "Sorry, you must give object.");
            return false;
        }

        $this->requestProject = $this->apiRequest->getUrl()->getApiProject();
        $this->requestObject = $this->apiRequest->getUrl()->getApiObject();

        // check if HTTP method used is supported
        if(!isset(IonXApi::$SUPPORTED_HTTP_METHODS[$this->apiRequest->getMethod()])) {
            $this->apiResponse->setResponseError(400, "Sorry, http method not supported.");
            return false;
        }

        // check if requested project exists in routes
        if($this->apiRoutes->getProject($this->requestProject)==null) {
            $this->apiResponse->setResponseError(400, "Sorry, given project ('".$this->requestProject."') doesn't exists in routes.");
            return false;
        }

        // check if requested project exists in folder
        if(!Util::file_exists_ci($this->config->getPathProjects().$this->requestProject)) {
            $this->apiResponse->setResponseError(400, "Sorry, the given project ('".$this->requestProject."') doesn't exists.");
            return false;
        }

        // check if requested object exists in routes
        if($this->apiRoutes->getProject($this->requestProject)->getObject($this->requestObject)==null) {
            $this->apiResponse->setResponseError(400, "Sorry, given object doesn't exists in routes.");
            return false;
        }

        // check if requested object exists in folder and include it
        $objectPath = Util::buildPath(
            $this->config->getPathProjects(),
            $this->requestProject,
            $this->config->getFolderNameModels(),
            $this->requestObject.".php");
        if(($objectPath = Util::file_exists_ci($objectPath)) === false) {
            $this->apiResponse->setResponseError(400, "Sorry, the given object class file doesn't exists.");
            return false;
        } else {
            require_once $objectPath;
        }

        // Check if request object class is accessible
        $this->requestObjectFullName = '\\'.$this->config->getAppNamespace()."\\projects\\"
            .$this->requestProject."\\".$this->config->getFolderNameModels()."\\".$this->requestObject;
        if(!class_exists($this->requestObjectFullName)) {
            $this->apiResponse->setResponseError(500, "Sorry, the object class is not reachable.");
            return false;
        }

        // Check if Manager Php file exists and include it
        $managerPath = Util::buildPath($this->config->getPathProjects(),
            $this->requestProject, $this->config->getFolderNameManagers(),
            $this->apiRoutes->getProject($this->requestProject)->getObject($this->requestObject)->getManager().".php");
        if(($managerPath = Util::file_exists_ci($managerPath)) === false) {
            $this->apiResponse->setResponseError(500, "Sorry, the given object has no manager.");
            return false;
        } else {
            require_once $managerPath;
        }

        // Check if Manager PHP Class is accessible
        $this->objectManagerFullName = '\\'.$this->config->getAppNamespace()."\\projects\\"
            .$this->requestProject."\\".$this->config->getFolderNameManagers()."\\"
            .$this->apiRoutes->getProject($this->requestProject)->getObject($this->requestObject)->getManager();
        if(!class_exists($this->objectManagerFullName)) {
            $this->apiResponse->setResponseError(500, "Sorry, there is an error with given object manager class.");
            return false;
        }

        // Check if there is a content-type defined for PUT or POST request
        if(($this->apiRequest->getMethod()=="POST" || $this->apiRequest->getMethod()=="PUT") && $this->apiRequest->getContentType()=="") {
            $this->apiResponse->setResponseError(400, "Sorry, for this action you have to specify content-type.");
            return false;
        }

        // check if defined content-type is supported
        if(($this->apiRequest->getMethod()=="POST" || $this->apiRequest->getMethod()=="PUT")
            && $this->apiRequest->getContentType()!=""
            && !isset(IonXApi::$SUPPORTED_CONTENT_TYPES[$this->apiRequest->getContentType()])) {
            $this->apiResponse->setResponseError(400, "Sorry, the given content type is not supported.");
            return false;
        }

        // check if request command exists in routes
        $this->requestCommand = strtolower($this->apiRequest->getMethod()).ucfirst($this->requestObject);
        if(Util::isGoodString($this->apiRoutes->getProject($this->requestProject)
                ->getObject($this->requestObject)->getCommand($this->requestCommand))
            && !$this->apiRoutes->getProject($this->requestProject)
                ->getObject($this->requestObject)->isQuickMethodEnabled()) {
            $this->apiResponse->setResponseError(400, "Sorry, given object hasn't any suitable method for this action in routes.");
            return false;
        }

        return true;
    }


    /**
     * Check the requested api command prerequisites in manager class
     */
    private function isValidApiCommand() {
        // Check if request command exists in class by name


    }

    /**
     * Check the ApiCommand entity fields security annotation and session cookie
     */
    private function isAuthorizedCommand() {

    }

    /**
     * Execute the command, instantiate the entity manager and try to call the right method
     */
    private function execCommand() {
        $method = $this->requestCommand;
        $apiUrl = $this->apiRequest->getUrl();

        // instantiate the right manager
        $mgr = new $this->objectManagerFullName();

        // get method and method params of the instantiated manager given method
        $reflectMethod = new ReflectionMethod($this->objectManagerFullName, $method);
        $numArgs = $reflectMethod->getNumberOfParameters();

        // final method parameters
        $args = $reflectMethod->getParameters();

        $parameters = array();

        foreach ($args as $arg) {
            // if arg required
            if (!$arg->isDefaultValueAvailable()) {

                if ($arg->getName() == "id" && $apiUrl->getApiObjectId() != "") {
                    $parameters[$arg->getPosition()] = $apiUrl->getApiObjectId();
                } elseif ($arg->getName() == "json" && $this->apiRequest->getBody() != "" && is_string($this->apiRequest->getBody())) {
                    $parameters[$arg->getPosition()] = $this->apiRequest->getBody();
                } else {
                    //if arg name defined in request Parameters
                    if (array_key_exists($arg->getName(), $apiUrl->getQuery())) {
                        $parameters[$arg->getPosition()] = $apiUrl->getQuery()[$arg->getName()];
                    } else {
                        $this->apiResponse->setResponseError(400, "A required parameter is not in the request parameters : " . $arg->getName());
                        break;
                    }
                }
                // if arg optional
            } else {
                //if arg name defined in request Parameters
                if (array_key_exists($arg->getName(), $apiUrl->getQuery())) {
                    $parameters[$arg->getPosition()] = $apiUrl->getQuery()[$arg->getName()];
                } else {
                    $parameters[$arg->getPosition()] = $arg->getDefaultValue();
                }
            }
        }

        // Error with number of args, send back BAD_REQUEST
        if ($numArgs != count($parameters)) {
            if ($this->apiResponse->getStatus() == "") {
                $this->apiResponse->setResponseError(400, "The request parameters don't follow the method required parameters."
                    . $numArgs . ","
                    . count($parameters) . ","
                    . $this->objectManagerFullName . "::"
                    . $method . ")");
            }
        } else {

            //order for method params:$id,$json,$requestParameters,....

            if (!call_user_func_array(array($mgr, $method), $parameters)) {
                if ($this->apiResponse->getStatus() == 200) {
                    $this->apiResponse->setResponseError(400, "The method which was called has failed (".$this->objectManagerFullName."::".$method.")");
                }
            }
        }
    }

    /**
     * Endpoint, this is the last function to be called
     * It sends the ApiResponse built by previous methods.
     */
    private function sendResponse(){

        header("Content-Type: ".$this->apiResponse->getContentType(), true, $this->apiResponse->getStatus());

        if(is_array($this->apiResponse->getBody())) {
            echo json_encode($this->apiResponse->getBody());
        } else {
            echo $this->apiResponse->getBody();
        }

        exit(0);
    }

    /**
     * @return \Symfony\Component\Console\Helper\HelperSet
     */
    public static function getCli() {
        new \IonXLab\IonXApi\util\EntityMgr();
        return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(EntityMgr::$entityManager);
    }

    /**
     * Shortcut to create the db schema from models
     * @return bool
     */
    public function createSchema() {
        $result = false;
        try {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool(EntityMgr::$entityManager);
            $classes = EntityMgr::$entityManager->getMetadataFactory()->getAllMetadata();
            $schemaTool->dropSchema($classes);
            $schemaTool->createSchema($classes);
            $result=true;
        } catch(\Exception $e) {
            $this->apiResponse->setResponseError(500, "There was a problem while creating the database schema.");
        }
        return $result;
    }

    /**
     * Shortcut to update the db schema
     * @return bool
     */
    public function updateSchema() {
        $result = false;
        try {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool(EntityMgr::$entityManager);
            $classes = EntityMgr::$entityManager->getMetadataFactory()->getAllMetadata();
            $schemaTool->updateSchema($classes);
            $result=true;
        } catch(\Exception $e) {
            $this->apiResponse->setResponseError(500, "There was a problem while updating the database schema.");
        }
        return $result;
    }

    /**
     * Shortcut to delete the db schema
     * @return bool
     */
    public function deleteSchema() {
        $result = false;
        try {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool(EntityMgr::$entityManager);
            $classes = EntityMgr::$entityManager->getMetadataFactory()->getAllMetadata();
            $schemaTool->dropSchema($classes);
            $result=true;
        } catch(\Exception $e) {
            $this->apiResponse->setResponseError(500, "There was a problem while dropping the database schema.");
        }
        return $result;
    }
}

?>