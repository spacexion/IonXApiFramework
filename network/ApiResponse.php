<?php

namespace IonXApi\network;

class ApiResponse {

	/**
	 * Status of the HTTP response
     * @type int
	 */
	private $status;
    /**
     * @type string
     */
	private $contentType;
    /**
     * @var array
     */
	private $body;
    /**
     * @var \IonXApi\network\ApiResponse
     */
    private static $instance = null;


    private function __construct() {
	}

    /**
     * Return current or new ApiResponse instance
     * @return ApiResponse
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new ApiResponse();
        }
        return self::$instance;
    }

    public function setResponseError($status, $message="") {
        $this->status = $status;
        if($message!="") {
            $this->body["api-error"] = $message;
        }
    }

	/**
	* @return int
	*/
	public function getStatus()
	{
	    return $this->status;
	}
	
	/**
	* @param int $status
	*/
	public function setStatus($status)
	{
	    $this->status = $status;
	}
	
	/**
	* @return string
	*/
	public function getContentType()
	{
	    return $this->contentType;
	}
	
	/**
	* @param string $contentType
	*/
	public function setContentType($contentType)
	{
	    $this->contentType = $contentType;
	}
	
	/**
	* @return string
	*/
	public function getBody()
	{
	    return $this->body;
	}
	
	/**
	* @param string $body
	*/
	public function setBody($body)
	{
	    $this->body = $body;
	}
}

?>