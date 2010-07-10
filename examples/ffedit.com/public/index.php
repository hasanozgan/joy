<?php

# Joy Web Framework Loading...
require_once 'Joy/Loader.php';
Joy_Loader::run();

define('APPLICATION_ROOT', realpath(dirname(__FILE__)."/../"));

# Application Envirement
defined('ENVIRONMENT_MODE') || 
    define('ENVIRONMENT_MODE', 
           (getenv('ENVIRONMENT_MODE') 
                ? getenv('ENVIRONMENT_MODE')
                : 'production')
          );


# Create Application
$app = new Joy_Application_Web(APPLICATION_ROOT, ENVIRONMENT_MODE);
$app->run();


