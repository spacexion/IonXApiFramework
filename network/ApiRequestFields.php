<?php

namespace IonXApi\network;

class ApiRequestFields {

	/**
	 * Content-Types that are acceptable for the response.
	 */
	const Accept = "Accept";
	
	const ACCEPT_JSON = "application/json";
	const ACCEPT_XML = "application/xml";
	
	/**
	 * Character sets that are acceptable
	 */
	const AcceptCharset = "Accept-Charset";
	
	/**
	 * List of acceptable encodings.
	 */
	const AcceptEncoding = "Accept-Encoding";
	
	/**
	 * List of acceptable human languages for response.
	 */
	const AcceptLanguage = "Accept-Language";

	const ACCEPT_LANGUAGE_FR = "fr_FR";
	const ACCEPT_LANGUAGE_EN = "en_EN";
	const ACCEPT_LANGUAGE_DE = "de_DE";
	const ACCEPT_LANGUAGE_ES = "es_ES";
	
	/**
	 * Acceptable version in time
	 */
	const AcceptDatetime = "Accept-Datetime";
	
	/**
	 * Authentication credentials for HTTP authentication
	 */
	const Authorization = "Authorization";
	
	/**
	 * Used to specify directives that must be obeyed by all caching mechanisms along the request-response chain
	 */
	const CacheControl = "Cache-Control";
	
	/**
	 * Control options for the current connection and list of hop-by-hop request fields
	 */
	const Connection = "Connection";
	
	/**
	 * An HTTP cookie previously sent by the server with Set-Cookie 
	 */
	const Cookie = "Cookie";
	
	/**
	 * The length of the request body in octets 
	 */
	const ContentLength = "Content-Length";
	
	/**
	 * A Base64-encoded binary MD5 sum of the content of the request body
	 */
	const ContentMD5 = "Content-MD5";
	
	/**
	 * The MIME type of the body of the request (used with POST and PUT requests)
	 */
	const ContentType = "Content-Type";
	
	/**
	 * The date and time that the message was sent (in "HTTP-date" format as defined by RFC 7231 Date/Time Formats
	 */
	const Date = "Date";
	
	/**
	 * Indicates that particular server behaviors are required by the client
	 */
	const Expect = "Expect";
	
	/**
	 * The email address of the user making the request
	 */
	const From = "From";
	
	/**
	 * The domain name of the server (for virtual hosting), and the TCP port number on which the server is listening. The port number may be omitted if the port is the standard port for the service requested. 
	 */
	const Host = "Host";
	
	/**
	 * Only perform the action if the client supplied entity matches the same entity on the server. This is mainly for methods like PUT to only update a resource if it has not been modified since the user last updated it.
	 */
	const IfMatch = "If-Match";
	
	/**
	 * Allows a 304 Not Modified to be returned if content is unchanged
	 */
	const IfModifiedSince = "If-Modified-Since";
	
	/**
	 * Allows a 304 Not Modified to be returned if content is unchanged, see HTTP ETag
	 */
	const IfNoneMatch = "If-None-Match";
	
	/**
	 * If the entity is unchanged, send me the part(s) that I am missing; otherwise, send me the entire new entity
	 */
	const IfRange = "If-Range";
	
	/**
	 * Only send the response if the entity has not been modified since a specific time.
	 */
	const IfUnmodifiedSince = "If-Unmodified-Since";
	
	/**
	 * Limit the number of times the message can be forwarded through proxies or gateways.
	 */
	const MaxForwards = "Max-Forwards";
	
	/**
	 * Initiates a request for cross-origin resource sharing (asks server for an 'Access-Control-Allow-Origin' response field) .
	 */
	const Origin = "Origin";
	
	/**
	 * Implementation-specific fields that may have various effects anywhere along the request-response chain.
	 */
	const Pragma = "Pragma";
	
	/**
	 * Authorization credentials for connecting to a proxy.
	 */
	const ProxyAuthorization = "Proxy-Authorization";
	
	/**
	 * Request only part of an entity. Bytes are numbered from 0.
	 */
	const Range = "Range";
	
	/**
	 * This is the address of the previous web page from which a link to the currently requested page was followed. (The word �referrer� has been misspelled in the RFC as well as in most implementations to the point that it has become standard usage and is considered correct terminology)
	 */
	const Referer = "Referer";
	
	/**
	 * The transfer encodings the user agent is willing to accept: the same values as for the response header field Transfer-Encoding can be used, plus the "trailers" value (related to the "chunked" transfer method) to notify the server it expects to receive additional fields in the trailer after the last, zero-sized, chunk.
	 */
	const TE = "TE";
	
	/**
	 * The user agent string of the user agent
	 */
	const UserAgent = "User-Agent";
	
	/**
	 * Ask the server to upgrade to another protocol.
	 */
	const Upgrade = "Upgrade";
	
	/**
	 * Informs the server of proxies through which the request was sent.
	 */
	const Via = "Via";
	
	/**
	 * A general warning about possible problems with the entity body.
	 */
	const Warning = "Warning";

	function __construct() {
	
	}

}


?>


