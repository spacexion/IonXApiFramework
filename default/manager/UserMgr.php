<?php

require_once str_replace('\\', '/', __DIR__."/")."../controller/UserController.php";
require_once str_replace('\\', '/', __DIR__."/")."../../abstract/BaseManager.php";
require_once str_replace('\\', '/', __DIR__."/")."../../abstract/SessionManager.php";

class UserMgr extends BaseMgr {

    public function __construct() {
        parent::__construct(new UserController(), "User");
    }

    /**
     * POST an authentication
     *
     * @api {post} /web/users/login post an authenticaton and result a token and a User
     * @apiName PostUserAuth
     * @apiGroup User
     *
     * @apiVersion 0.5.0
     *
     * @apiParam {Json} User Object.
     *     	{
     *     		"password":"test",
     *    		"email":"test@gmail.com"
     *     	}
     *
     * @apiSuccess {Json} User Object.
     *
     * @apiSuccessExample Success-Response:
     * 		HTTP/1.1 200 OK, Authorization: ionxionxionxionxionxtoken
     *     	{
     *    		"id":1,
     *    		"firstname":"bob",
     *     		"lastname":"",
     *    		"email":"test@gmail.com",
     *    		"authLevel":1
     *     	}
     *
     * @apiErrorTitle (404) Error 404
     * @apiError (404) UserNotFound The given user was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     */
    public function loginUser($json) {

        $userJson = json_decode($json);
        $mapper = new JsonMapper();
        $user = $mapper->map($userJson, new User());
        $user->setPassword(hash("sha512", $user->getPassword()));

        $result = $this->controller->readUserByEmailAndPassword($user->getEmail(), $user->getPassword());

        if ($result == null) {
            ApiHttpResponse::setHttpStatusCode(404);
            ApiHttpResponse::addErrorMessage("The provided email/username:password don't match.");
            return false;
        } else {
            /* $sessionMgr = new SessionManager();
              $sessionMgr->loginUser($result); */
            $_SESSION["USER"] = $result;

            ApiHttpResponse::setContent(json_encode($result->toArray()));
            return true;
        }
    }

    /**
     * GET logout the user
     *
     * @api {get} /web/users/logout Logout User
     * @apiName LogoutUser
     * @apiGroup User
     *
     * @apiVersion 0.5.0
     *
     *
     * @apiSuccess {Json} User Object.
     *
     * @apiSuccessExample Success-Response:
     * 		HTTP/1.1 200 OK
     *
     * @apiErrorTitle (409) Error 409
     * @apiError (409) SessionError The user is not logged in.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 409 Conflict
     */
    public function logoutUser() {
        //$sessionMgr = new SessionManager();
        //if($sessionMgr->isUserLogged()) {
        //$sessionMgr->logoutUser();

        if (isset($_SESSION["USER"]) && $_SESSION["USER"] != null && is_object($_SESSION["USER"])) {
            $_SESSION["USER"] = null;
            ApiHttpResponse::setHttpStatusCode(200);
            return true;
        } else {
            ApiHttpResponse::setHttpStatusCode(409);
            ApiHttpResponse::addErrorMessage("The user is not logged in.");
            return false;
        }
    }

    /**
     * POST create a new User
     * 
     * @api {post} /web/users Create a new User
     * @apiName PostUser
     * @apiGroup User
     * 
     * @apiVersion 0.5.0
     *
     * @apiParam {Json} User Object.
     *     	{
     *    		"firstname":"bob",
     *     		"lastname":"",
     *     		"password":"test",
     *    		"email":"test@gmail.com"
     *     	}
     *
     * @apiSuccess {Json} User Object.
     *
     * @apiSuccessExample Success-Response:
     * 		HTTP/1.1 200 OK
     *     	{
     *    		"id":1,
     *    		"firstname":"bob",
     *     		"lastname":"",
     *    		"email":"test@gmail.com",
     *    		"authLevel":1
     *     	}
     *
     * @apiErrorTitle (409) Error 409
     * @apiError (409) UserEmailConflict The email of the given User exists.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 409 Conflict
     */
    public function postUser($json) {
        $userJson = json_decode($json);
        $mapper = new JsonMapper();
        $user = $mapper->map($userJson, new User());

        $user->setPassword(hash("sha512", $user->getPassword()));

        $newUser = $this->controller->createUser($user);

        if ($newUser == null) {
            ApiHttpResponse::setHttpStatusCode(409);
            ApiHttpResponse::addErrorMessage("A User has already this Email and Or Username");
            return false;
        } else {
            return $this->loginUser($json);
        }
    }

    /**
     * GET get the user
     *
     * @api {get} /web/users/$id Request User
     * @apiName GetUser
     * @apiGroup User
     *
     * @apiVersion 0.5.0
     *
     * @apiParam {Number} id Users unique ID.
     *
     * @apiSuccess {Json} User Object.
     *
     * @apiSuccessExample Success-Response:
     * 		HTTP/1.1 200 OK
     *     	{
     *    		"id":1,
     *    		"firstname":"bob",
     *     		"lastname":"",
     *    		"email":"test@gmail.com",
     *    		"authLevel":1
     *     	}
     *
     * @apiErrorTitle (404) Error 404
     * @apiError (404) UserNotFound The given user was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     */
    public function getUser($id) {
        return $this->getObject($id);
    }

    /**
     * GET get the current logged user
     *
     * @api {get} /web/users/current Request current logged User
     * @apiName GetCurrentUser
     * @apiGroup User
     *
     * @apiVersion 0.5.0
     *
     * @apiSuccess {Json} User Object.
     *
     * @apiSuccessExample Success-Response:
     * 		HTTP/1.1 200 OK
     *     	{
     *    		"id":1,
     *    		"firstname":"bob",
     *     		"lastname":"",
     *    		"email":"test@gmail.com",
     *    		"authLevel":1
     *     	}
     *
     * @apiErrorTitle (404) Error 404
     * @apiError (404) UserNotFound The given user was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     */
    public function getCurrentUser() {
        /* $sessionMgr = new SessionManager();

          if($sessionMgr->isUserLogged()) {
          return $sessionMgr->getUser();
          } */
        if (isset($_SESSION["USER"]) && $_SESSION["USER"] != null && is_object($_SESSION["USER"])) {
            ApiHttpResponse::setContent(json_encode($_SESSION["USER"]->toArray()));
            return true;
        }

        ApiHttpResponse::addErrorMessage("The user is not logged.");
        return false;
    }

    /**
     * GET get the users
     * 
     * @api {get} /web/users?limit=$limit&offset=$offset&&sort=$offset&query=$query Request Users list
     * @apiName GetUsers
     * @apiGroup User
     * 
     * @apiVersion 0.5.0
     *
     * @apiSuccess {array(Json)} array(User) Object.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     [{
     *     		{
     *    	 		"id":1,
     *    	 		"firstname":"bob",
     *     			"lastname":"",
     *     			"password":"test",
     *    	 		"email":"test@gmail.com",
     *    	 		"authLevel":1
     *     		},
     *     		{
     *    	 		"id":2,
     *    	 		"firstname":"test",
     *     			"lastname":"",
     *     			"password":"test",
     *    	 		"email":"test2@gmail.com",
     *    	 		"authLevel":1
     *     		}
     *     }]
     *
     * @apiErrorTitle (404) Error
     * @apiError (404) UserNotFound The given user was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     */
    public function getUsers($limit = 50, $offset = 0, $sort = "", $query = "") {
        return $this->getObjects($limit, $offset, $sort, $query);
    }

    /**
     * PUT update a user
     *
     * @api {put} /web/users Update a User
     * @apiName PutUser
     * @apiGroup User
     * 
     * @apiVersion 0.5.0
     *
     * @apiParam {Json} User Object.
     *     	{
     *    		"id":1,
     *    		"firstname":"bob",
     *     		"lastname":"",
     *     		"password":"test",
     *    		"email":"test@gmail.com",
     *    		"authLevel":1
     *     	}
     *
     * @apiSuccess {Json} User Object.
     *
     * @apiSuccessExample Success-Response:
     * 		HTTP/1.1 200 OK
     *     	{
     *    		"id":1,
     *    		"firstname":"bob",
     *     		"lastname":"",
     *    		"email":"test@gmail.com",
     *    		"authLevel":1
     *     	}
     *
     * @apiErrorTitle (404) Error 404
     * @apiError (404) UserNotFound The given user was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     */
    public function putUser($id, $json) {
        return $this->putObject($id, $json, "updateUser");
    }

    /**
     * DELETE delete a user
     * 
     * @api {delete} /web/users/$id Delete User
     * @apiName DeleteUser
     * @apiGroup User
     * 
     * @apiVersion 0.5.0
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     * @apiErrorTitle (404) Error 404
     * @apiError (404) UserNotFound The given user was not found.
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     * 
     * @apiErrorTitle (500) Error 500
     * @apiError (500) UserDeleteError The user was not deleted.
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 500 Internal Server Error
     */
    public function deleteUser($id) {
        return $this->deleteObject($id);
    }

}

?>