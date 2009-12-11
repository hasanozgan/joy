<?php

# Joy Web Framework Loading...
require_once 'Joy/Loader.php';
Joy_Loader::run();

define('APPLICATION_ROOT', realpath(dirname(__FILE__)."/../"));

# Application Root
set_include_path(
    APPLICATION_ROOT . '/library'
    . PATH_SEPARATOR . get_include_path()
);

# Application Envirement
defined('ENVIRONMENT_MODE') || 
    define('ENVIRONMENT_MODE', 
           (getenv('ENVIRONMENT_MODE') 
                ? getenv('ENVIRONMENT_MODE')
                : 'production')
          );


# Create Application
$app = new Joy_Application(APPLICATION_ROOT, ENVIRONMENT_MODE);
$app->run();


