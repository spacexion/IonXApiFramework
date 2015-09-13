<?php

namespace IonXLab\IonXApi\routes;
use Exception;

/**
 * Class ApiCommand
 *
 * Allows to define a command route for an api object
 */
class ApiCommand {

    private $managerMethod;
    private $requestMethod;
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
        } else {
            $this->requestMethod = $requestMethod;
        }
        $this->authenticationLevel = (is_int($authenticationLevel) ? $authenticationLevel : 0);

        $this->requestContentType = (is_string($requestContentType) ? $requestContentType : "application/json");
        $this->responseContentType = (is_string($responseContentType) ? $responseContentType : "application/json");
    }

    /**
     * @return int
     */
    public function getAuthenticationLevel() {
        return $this->authenticationLevel;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->managerMethod;
    }

    /**
     * @return string
     */
    public function getManagerMethod() {
        return $this->managerMethod;
    }

    /**
     * @return string
     */
    public function getRequestContentType() {
        return $this->requestContentType;
    }

    /**
     * @return string
     */
    public function getRequestMethod() {
        return $this->requestMethod;
    }

    /**
     * @return string
     */
    public function getResponseContentType() {
        return $this->responseContentType;
    }
} 