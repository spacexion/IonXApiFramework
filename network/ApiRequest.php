<?php

require_once realpath(__DIR__."/ApiUrl.php");

class ApiRequest {

	/**
	 * Content-Types that are acceptable for the response.
	 */
	private $accept = "";
	/**
	 * List of acceptable human languages for response.
	 */
	private $acceptLanguage = "";
	/**
	 * Authentication credentials for HTTP authentication
	 */
	private $authorization = "";
	/**
	 * The MIME type of the body of the request (used with POST and PUT requests)
	 */
	private $contentType = "";
	/**
	 * The length of the request body in octets 
	 */
	private $contentLength = "";
	/**
	 * A Base64-encoded binary MD5 sum of the content of the request body
	 */
	private $contentMD5 = "";
	/**
	 * The date and time that the message was sent (in "HTTP-date" format as defined by RFC 7231 Date/Time Formats
	 */
	private $date = "";
	/**
	 * Request only part of an entity. Bytes are numbered from 0.
	 */
	private $range = "";
	/**
	 * This is the address of the previous web page from which a link to the currently requested page was followed. (The word �referrer� has been misspelled in the RFC as well as in most implementations to the point that it has become standard usage and is considered correct terminology)
	 */
	private $referer= "";
	/**
	 * The user agent string of the user agent
	 */
	private $userAgent = "";


	/**
	 * The user ip address
	 */
	private $userIP = "";
	/**
	 * The user host
	 */
	private $userHost = "";
	
	
	/**
	 * The request method (GET,POST,PUT,DELETE)
	 */
	private $method = "";
	/**
	 * The request url data as ApiUrl object (See: RequestParser::parse())
	 */
	private $url;
    /**
     * HTTP cookies previously sent by the server with Set-Cookie
     */
    private $cookies = "";
	
	/**
	 * Request Body
	 */
	private $body = "";
	
	
	public function __construct() {

	}

	/**
	* @return string
	*/
	public function getAccept()
	{
	    return $this->accept;
	}
	
	/**
	* @param string $accept
	*/
	public function setAccept($accept)
	{
	    $this->accept = $accept;
	}
	
	/**
	* @return string
	*/
	public function getAcceptLanguage()
	{
	    return $this->acceptLanguage;
	}
	
	/**
	* @param string $acceptLanguage
	*/
	public function setAcceptLanguage($acceptLanguage)
	{
	    $this->acceptLanguage = $acceptLanguage;
	}
	
	/**
	* @return string
	*/
	public function getAuthorization()
	{
	    return $this->authorization;
	}
	
	/**
	* @param string $authorization
	*/
	public function setAuthorization($authorization)
	{
	    $this->authorization = $authorization;
	}
	
	/**
	* @return array(ApiCookie)
	*/
	public function getCookies()
	{
	    return $this->cookies;
	}
	
	/**
	* @param array(ApiCookie) $cookies
	*/
	public function setCookies($cookies)
	{
	    $this->cookies = $cookies;
	}
	
	/**
	 * @param ApiCookie $cookie
	 */
	public function addCookie($cookie)
	{
		$this->cookie[] = $cookie;
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
	* @return int
	*/
	public function getContentLength()
	{
	    return $this->contentLength;
	}
	
	/**
	* @param int $contentLength
	*/
	public function setContentLength($contentLength)
	{
	    $this->contentLength = $contentLength;
	}

	/**
	* @return string
	*/
	public function getContentMD5()
	{
	    return $this->contentMD5;
	}
	
	/**
	* @param string $contentMD5
	*/
	public function setContentMD5($contentMD5)
	{
	    $this->contentMD5 = $contentMD5;
	}
	
	/**
	* @return string
	*/
	public function getDate()
	{
	    return $this->date;
	}
	
	/**
	* @param string $date
	*/
	public function setDate($date)
	{
	    $this->date = $date;
	}
	
	/**
	* @return string
	*/
	public function getRange()
	{
	    return $this->range;
	}
	
	/**
	* @param string $range
	*/
	public function setRange($range)
	{
	    $this->range = $range;
	}
	
	/**
	* @return string
	*/
	public function getReferer()
	{
	    return $this->referer;
	}
	
	/**
	* @param string $referer
	*/
	public function setReferer($referer)
	{
	    $this->referer = $referer;
	}
	
	/**
	* @return string
	*/
	public function getUserAgent()
	{
	    return $this->userAgent;
	}
	
	/**
	* @param string $userAgent
	*/
	public function setUserAgent($userAgent)
	{
	    $this->userAgent = $userAgent;
	}
	
	/**
	* @return string
	*/
	public function getUserIp()
	{
	    return $this->userIP;
	}
	
	/**
	* @param string $userIP
	*/
	public function setUserIp($userIP)
	{
	    $this->userIP = $userIP;
	}
	
	/**
	* @return string
	*/
	public function getUserHost()
	{
	    return $this->userHost;
	}
	
	/**
	* @param string $userHost
	*/
	public function setUserHost($userHost)
	{
	    $this->userHost = $userHost;
	}
	
	/**
	* @return int
	*/
	public function getMethod()
	{
	    return $this->method;
	}
	
	/**
	* @param int $method
	*/
	public function setMethod($method)
	{
	    $this->method = $method;
	}
	
	/**
	* @return ApiUrl
	*/
	public function getUrl()
	{
	    return $this->url;
	}
	
	/**
	* @param ApiUrl $url
	*/
	public function setUrl($url)
	{
	    $this->url = $url;
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
