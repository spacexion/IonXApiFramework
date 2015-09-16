<?php

use IonXLab\IonXApi\Config;
use IonXLab\IonXApi\routes\ApiCommand;
use IonXLab\IonXApi\routes\ApiObject;
use IonXLab\IonXApi\routes\ApiProject;
use IonXLab\IonXApi\routes\ApiRoutes;

$routes = new ApiRoutes(array(
    new ApiProject("Web",array(
        new ApiObject("Article",array(
            new ApiCommand("getArticle", "GET"),
            new ApiCommand("postArticle", "POST"),
            new ApiCommand("putArticle", "PUT"),
            new ApiCommand("deleteArticle", "DELETE")
        ))
    ))
));

Config::getInstance()->init(
    "MyTestApp",
    "ionxapi",
    "ionxapi",
    "localhost",
    3306,
    "ionxlab",
    $routes,
    "api/",
    "/var/www/vendor/ionxlab/ionxapi/",
    "/var/www/api/projects/",
    "controllers",
    "models",
    "managers",
    true);

return Config::getInstance();