<?php

namespace IonXLab\IonXApi\network;

/**
 * ApiUrl is a class that represents the Url as an object.
 * Structure is as follow:
 * [scheme]://[host]:[port]@[user]:[pass][path]?[query]#[fragment]
 * @author XION
 */
class ApiUrl {

	private $scheme;
	private $host;
	private $port;
	private $user;
	private $pass;
    private $path;
	private $query;
	private $fragment;

    private $apiProject;
    private $apiObject;
    private $apiObjectId;

    /**
     * @return int
     */
    public function getApiObjectId()
    {
        return $this->apiObjectId;
    }

    /**
     * @param int $apiObjectId
     */
    public function setApiId($apiObjectId)
    {
        $this->apiObjectId = $apiObjectId;
    }

    /**
     * @return string
     */
    public function getApiObject()
    {
        return $this->apiObject;
    }

    /**
     * @param string $apiObject
     */
    public function setApiObject($apiObject)
    {
        $this->apiObject = $apiObject;
    }

    /**
     * @return string
     */
    public function getApiProject()
    {
        return $this->apiProject;
    }

    /**
     * @param string $apiProject
     */
    public function setApiProject($apiProject)
    {
        $this->apiProject = $apiProject;
    }

	public function __construct() {
		
	}
	
	/**
	* @return string
	*/
	public function getScheme()
	{
	    return $this->scheme;
	}
	
	/**
	* @param string $scheme
	*/
	public function setScheme($scheme)
	{
	    $this->scheme = $scheme;
	}
	
	/**
	* @return string
	*/
	public function getHost()
	{
	    return $this->host;
	}
	
	/**
	* @param string $host
	*/
	public function setHost($host)
	{
	    $this->host = $host;
	}
	
	/**
	* @return int
	*/
	public function getPort()
	{
	    return $this->port;
	}
	
	/**
	* @param int $port
	*/
	public function setPort($port)
	{
	    $this->port = $port;
	}
	
	/**
	* @return string
	*/
	public function getUser()
	{
	    return $this->user;
	}
	
	/**
	* @param string $user
	*/
	public function setUser($user)
	{
	    $this->user = $user;
	}
	
	/**
	* @return string
	*/
	public function getPass()
	{
	    return $this->pass;
	}
	
	/**
	* @param string $pass
	*/
	public function setPass($pass)
	{
	    $this->pass = $pass;
	}

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getPathArray()
    {
        return explode('/', $this->path);
    }
	
	/**
	* @param string $path
	*/
	public function setPath($path)
	{
	    $this->path = $path;
	}
	
	/**
	* @return array
	*/
	public function getQuery()
	{
	    return $this->query;
	}
	
	/**
	* @param array $query
	*/
	public function setQuery($query)
	{
	    $this->query = $query;
	}
	
	/**
	* @return string
	*/
	public function getFragment()
	{
	    return $this->fragment;
	}
	
	/**
	* @param string $fragment
	*/
	public function setFragment($fragment)
	{
	    $this->fragment = $fragment;
	}


    /**
     * Return [scheme]://[host]:[port]
     * @param bool $use_forwarded_host
     * @return string
     */
    public function getOriginUrl($use_forwarded_host=false)
    {
        $s = $_SERVER;
        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
        $sp = strtolower($s['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port = $s['SERVER_PORT'];
        $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
        $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST']))
            ? $s['HTTP_X_FORWARDED_HOST']
            : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
        $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
        return $protocol . '://' . $host;
    }

    /**
     * Return [scheme]://[host]:[port][path]?[query]#[fragment]
     * @param bool $use_forwarded_host
     * @return string
     */
    public function getFullUrl($use_forwarded_host=false)
    {
        $s = $_SERVER;
        return $this->getOriginUrl($use_forwarded_host) . $s['REQUEST_URI'];
    }
}

?>