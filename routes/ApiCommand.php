<?php

/**
 * Class ApiCommand
 *
 * Allows to define a command route for an api object
 */
class ApiCommand {

    private $managerMethod = "";
    private $requestMethod = "";
    private $requestContentType = "application/json";
    private $responseContentType = "application/json";
    private $authenticationLevel = 0;

    /**
     * @param string $managerMethod The BaseMgr::method() name
     * @param string $requestMethod POST, GET, PUT, DELETE
     * @param int $authenticationLevel
     * @param string $requestContentType
     * @param string $responseContentType
     * @throws Exception
     */
    public function __construct($managerMethod,
                                $requestMethod,
                                $authenticationLevel=0,
                                $requestContentType="application/json",
                                $responseContentType="application/json") {
        $this->managerMethod = $managerMethod;
        if($requestMethod != ("POST" || "GET" || "PUT" || "DELETE")) {
            throw new Exception("Given request method is not supported.");
        }
        $this->requestMethod = $requestMethod;
        $this->authenticationLevel = $authenticationLevel;
    }

    /**
     * @return int
     */
    public function getAuthenticationLevel()
    {
        return $this->authenticationLevel;
    }

    /**
     * @param int $authenticationLevel
     */
    public function setAuthenticationLevel($authenticationLevel)
    {
        $this->authenticationLevel = $authenticationLevel;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->managerMethod;
    }

    /**
     * @return string
     */
    public function getManagerMethod()
    {
        return $this->managerMethod;
    }

    /**
     * @param string $managerMethod
     */
    public function setManagerMethod($managerMethod)
    {
        $this->managerMethod = $managerMethod;
    }

    /**
     * @return string
     */
    public function getRequestContentType()
    {
        return $this->requestContentType;
    }

    /**
     * @param string $requestContentType
     */
    public function setRequestContentType($requestContentType)
    {
        $this->requestContentType = $requestContentType;
    }

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * @param string $requestMethod
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * @return string
     */
    public function getResponseContentType()
    {
        return $this->responseContentType;
    }

    /**
     * @param string $responseContentType
     */
    public function setResponseContentType($responseContentType)
    {
        $this->responseContentType = $responseContentType;
    }

    public function setProjects($projects)
    {
        $this->projects->setObjects($projects);
    }
} 