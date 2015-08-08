<?php

namespace com\ionxlab\ionxapi\network;

/**
 * ApiCookie is class which represent an HTTP Cookie
 * @author XION
 */
class ApiCookie {

	/**
	 * String name
	 */
	private $name;
	/**
	 * String value
	 */
	private $value;
	/**
	 * String expire date
	 */
	private $expire;
	/**
	 * String path
	 */
	private $path;
	/**
	 * boolean secure
	 */
	private $secure;
	/**
	 * boolean httpOnly
	 */
	private $httpOnly;

	public function __construct() {
		
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
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
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * @return boolean
	 */
	public function getSecure()
	{
		return $this->secure;
	}

	/**
	 * @param boolean $secure
	 */
	public function setSecure($secure)
	{
		$this->secure = $secure;
	}

	/**
	 * @return boolean
	 */
	public function getHttpOnly()
	{
		return $this->httpOnly;
	}

	/**
	 * @param boolean $httpOnly
	 */
	public function setHttpOnly($httpOnly)
	{
		$this->httpOnly = $httpOnly;
	}
}

?>