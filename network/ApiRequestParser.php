<?php

require_once realpath(__DIR__."/ApiRequest.php");
require_once realpath(__DIR__."/ApiCookie.php");

/**
 * ApiRequestParser is a class that allow to parse request data
 * @author XION
 */
class ApiRequestParser {
	
	
	public function __construct() {
		
	}
	
	/**
	 * Parse the request in an apiRequest Object instance
	 * @return apiRequest
	 */
	public function parse() {
		$apiRequest = new ApiRequest();

		$apiRequest->setMethod($_SERVER["REQUEST_METHOD"]);
		$apiRequest->setContentType((isset($_SERVER["CONTENT_TYPE"]) ?
				$_SERVER["CONTENT_TYPE"] : ""));
		$apiRequest->setRange((isset($_SERVER["CONTENT_RANGE"]) ?
				$_SERVER["CONTENT_RANGE"] : ""));
		$apiRequest->setAuthorization((isset($_SERVER["AUTHORIZATION"]) ?
				$_SERVER["AUTHORIZATION"] : ""));
	
		$url = parse_url("api://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
		if(isset($url["query"])) {
			parse_str($url["query"], $queryArray);
			$url["query"] = $queryArray;
		}

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$apiRequest->setUserIP($_SERVER['HTTP_CLIENT_IP']);
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$apiRequest->setUserIP($_SERVER['HTTP_X_FORWARDED_FOR']);
		} else {
			$apiRequest->setUserIP($_SERVER['REMOTE_ADDR']);
		}
		
		$apiRequest->setUserHost((isset($_SERVER["REMOTE_HOST"]) ? $_SERVER["REMOTE_HOST"] : ""));
		$apiRequest->setUserAgent((isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : ""));

		$apiRequest->setCookies($this->parseCookies());


        $apiRequest->setUrl($this->parseUrl());

		return $apiRequest;
	}
	
	/**
	 * Parse the cookies
	 * @return array(HttpCookie)
	 */
	public function parseCookies() {
		
		$cookies = array();

		foreach($_COOKIE as $cookieName => $cookieValue) {
			$apiCookie = new ApiCookie();
			$apiCookie->setName($cookieName);
			$apiCookie->setValue($cookieValue);
			$cookies[] = $apiCookie;
		}
		
		return $cookies;
	}

    /**
     * Parse the url
     * @return ApiUrl
     */
    public function parseUrl() {
        $apiUrl = new ApiUrl();
        $url = parse_url($apiUrl->getFullUrl());

        $apiUrl->setScheme((isset($url["scheme"]) ? $url["scheme"] : ""));
        $apiUrl->setHost((isset($url["host"]) ? $url["host"] : ""));
        $apiUrl->setPort((isset($url["port"]) ? $url["port"] : ""));
        $apiUrl->setUser((isset($url["user"]) ? $url["user"] : ""));
        $apiUrl->setPass((isset($url["pass"]) ? $url["pass"] : ""));
        $apiUrl->setPath((isset($url["path"]) ? $url["path"] : ""));
        $apiUrl->setFragment((isset($url["fragment"]) ? $url["fragment"] : ""));

        if(isset($url["path"])) {
            $path = $url["path"];
            $path = trim(str_replace(Config::$uriApi, "", trim($path, '/')), '/');
            $pathArray = explode('/', $path);

            if(isset($pathArray[0])) {
                $apiUrl->setApiProject($pathArray[0]);
            }
            if(isset($pathArray[1])) {
                $apiUrl->setApiObject($pathArray[1]);
            }
            if(isset($pathArray[2])) {
                $apiUrl->setApiId($pathArray[2]);
            }
        }

        if(isset($url["query"])) {
            parse_str($url["query"], $urlQuery);
            $apiUrl->setQuery($urlQuery);
        }
        return $apiUrl;
    }
}


?>