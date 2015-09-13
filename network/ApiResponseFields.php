<?php

namespace IonXLab\IonXApi\network;

class ApiResponseFields {


	/**
	 * Specifying which web sites can participate in cross-origin resource sharing
	 */
	const AccessControlAllowOrigin = "Access-Control-Allow-Origin";
	
	/**
	 * Specifies which patch document formats this server supports
	 */
	const AcceptPatch = "Accept-Patch";
	
	/**
	 * What partial content range types this server supports
	 */
	const AcceptRanges = "Accept-Ranges";
	
	/**
	 * The age the object has been in a proxy cache in seconds
	 */
	const Age = "Age";
	
	/**
	 * Valid actions for a specified resource. To be used for a 405 Method not allowed
	 */
	const Allow = "Allow";
	
	/**
	 * Tells all caching mechanisms from server to client whether they may cache this object. It is measured in seconds
	 */
	const CacheControl = "Cache-Control";
	
	/**
	 * Control options for the current connection and list of hop-by-hop response fields
	 */
	const Connection = "Connection";
	
	/**
	 * An opportunity to raise a "File Download" dialogue box for a known MIME type with binary format or suggest a filename for dynamic content. Quotes are necessary with special characters.
	 */
	const ContentDisposition = "Content-Disposition";
	
	/**
	 * The type of encoding used on the data.
	 */
	const ContentEncoding = "Content-Encoding";
	
	/**
	 * The natural language or languages of the intended audience for the enclosed content
	 */
	const ContentLanguage = "Content-Language";
	
	/**
	 * The length of the response body in octets
	 */
	const ContentLength = "Content-Length";
	
	/**
	 * An alternate location for the returned data
	 */
	const ContentLocation = "Content-Location";
	
	/**
	 * A Base64-encoded binary MD5 sum of the content of the response
	 */
	const ContentMD5 = "Content-MD5";
	
	/**
	 * Where in a full body message this partial message belongs
	 */
	const ContentRange = "Content-Range";
	
	/**
	 * The MIME type of this content
	 */
	const ContentType = "Content-Type";
	
	/**
	 * The date and time that the message was sent (in "HTTP-date" format as defined by RFC 7231)
	 */
	const Date = "Date";
	
	/**
	 * An identifier for a specific version of a resource, often a message digest
	 */
	const ETag = "ETag";
	
	/**
	 * Gives the date/time after which the response is considered stale (in "HTTP-date" format as defined by RFC 7231)
	 */
	const Expires = "Expires";
	
	/**
	 * The last modified date for the requested object (in "HTTP-date" format as defined by RFC 7231)
	 */
	const LastModified = "Last-Modified";
	
	/**
	 * Used to express a typed relationship with another resource, where the relation type is defined by RFC 5988
	 */
	const Link = "Link";
	
	/**
	 * Used in redirection, or when a new resource has been created.
	 */
	const Location = "Location";
	
	/**
	 * This field is supposed to set P3P policy, in the form of P3P:CP="your_compact_policy". However, P3P did not take off,[32] most browsers have never fully implemented it, a lot of websites set this field with fake policy text, that was enough to fool browsers the existence of P3P policy and grant permissions for third party cookies.
	 */
	const P3P = "P3P";
	
	/**
	 * Implementation-specific fields that may have various effects anywhere along the request-response chain.
	 */
	const Pragma = "Pragma";
	
	/**
	 * Request authentication to access the proxy.
	 */
	const ProxyAuthenticate = "Proxy-Authenticate";
	
	/**
	 * Used in redirection, or when a new resource has been created. This refresh redirects after 5 seconds.
	 */
	const Refresh = "Refresh";
	
	/**
	 * If an entity is temporarily unavailable, this instructs the client to try again later. Value could be a specified period of time (in seconds) or a HTTP-date.[33]
	 */
	const RetryAfter = "Retry-After";
	
	/**
	 * A name for the server
	 */
	const Server = "Server";
	
	/**
	 * An HTTP cookie
	 */
	const SetCookie = "Set-Cookie";
	
	/**
	 * CGI header field specifying the status of the HTTP response. Normal HTTP responses use a separate "Status-Line" instead, defined by RFC 7230.[34]
	 */
	const Status = "Status";
	
	/**
	 * A HSTS Policy informing the HTTP client how long to cache the HTTPS only policy and whether this applies to subdomains.
	 */
	const StrictTransportSecurity = "Strict-Transport-Security";
	
	/**
	 * The Trailer general field value indicates that the given set of header fields is present in the trailer of a message encoded with chunked transfer coding.
	 */
	const Trailer = "Trailer";
	
	/**
	 * The form of encoding used to safely transfer the entity to the user. Currently defined methods are: chunked, compress, deflate, gzip, identity.
	 */
	const TransferEncoding = "Transfer-Encoding";
	
	/**
	 * Ask the client to upgrade to another protocol.
	 */
	const Upgrade = "Upgrade";
	
	/**
	 *  	Tells downstream proxies how to match future request headers to decide whether the cached response can be used rather than requesting a fresh one from the origin server.
	 */
	const Vary = "Vary";
	
	/**
	 * Informs the client of proxies through which the response was sent.
	 */
	const Via = "Via";
	
	/**
	 * A general warning about possible problems with the entity body.
	 */
	const Warning = "Warning";
	
	/**
	 * Indicates the authentication scheme that should be used to access the requested entity.
	 */
	const WWWAuthenticate = "WWW-Authenticate";


	public function __construct() {
	
	}

}


?>


