<?php
require_once realpath(__DIR__."/Config.php");
require_once realpath(__DIR__."/network/ApiRequest.php");
require_once realpath(__DIR__."/network/ApiResponse.php");
require_once realpath(__DIR__."/network/ApiRequestParser.php");
require_once realpath(__DIR__."/routes/ApiCommand.php");
require_once realpath(__DIR__."/routes/ApiObject.php");
require_once realpath(__DIR__."/routes/ApiProject.php");
require_once realpath(__DIR__."/routes/ApiRoutes.php");

/**
 * IonX Api Framework (30/03/2015) <br/>
 * This is the main class of this framework.
 * 
 * @author Nicolas Gezequel
 * @version 0.6.0
 *
 */
class IonXApi {

    /**
     * ApiRequest apiRequest
     */
    private $apiRequest;
    /**
     * ApiResponse apiResponse
     */
    private $apiResponse;
	
	public function __construct($routes) {
		
		$requestParser = new ApiRequestParser();
		$this->apiRequest = $requestParser->parse();
	}

    /**
     * Start the api processes and send the built ApiResponse
     */
	public function process() {

        $this->printRequest();

	}

    /**
     * Check if required data are presents and meets the api structure
     */
    private function isValidApiRequest() {

    }

    /**
     * Use ApiRequest data to build the api command
     */
    private function buildCommand() {

    }

    /**
     * Check the ApiCommand entity fields security annotation and session cookie
     */
    private function isAuthorizedCommand() {

    }

    /**
     *
     */
    private function execCommand() {

    }

    /**
     * DEBUG: print useful Request Data
     */
    private function printRequest() {

        echo "Method: ".$this->apiRequest->getMethod()."</br>";
        echo "UserIp: ".$this->apiRequest->getUserIp()."</br>";
        echo "UserHost: ".$this->apiRequest->getUserHost()."</br>";
        echo "UserAgent: ".$this->apiRequest->getUserAgent()."</br>";
        echo "ContentType: ".$this->apiRequest->getContentType()."</br>";
        echo "Range: ".$this->apiRequest->getRange()."</br>";
        echo "Auth: ".$this->apiRequest->getAuthorization()."</br>";
        echo "Url: </br>";
        echo "<pre>";
        print_r($this->apiRequest->getUrl());
        echo "</pre>";

        foreach($this->apiRequest->getCookies() as $cookie) {
            echo "Cookie: ".$cookie->getName()."</br>";
        }
    }

    /**
     * Endpoint, this is the last function to be called
     * It sends the ApiResponse built by previous methods.
     */
    private function sendResponse(){

    }
	
}

?>