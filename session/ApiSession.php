<?php

namespace com\ionxlab\ionxapi\session;

/**
 * User: XION
 * Date: 24/06/2015
 * Time: 01:37
 */


class ApiSession {

    private $token;

    public function __construct(ApiRequest $apiRequest) {

        $cookies = $apiRequest->getCookies();
    }
}



?>