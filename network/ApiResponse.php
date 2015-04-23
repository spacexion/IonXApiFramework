<?php


class ApiResponse {

	/**
	 * Status of the HTTP response
	 */
	private $status;
	private $contentType;
	private $body;

	public function __construct() {
	
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