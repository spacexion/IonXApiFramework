<?php


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

	public function __construct() {

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