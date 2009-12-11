<?php

if (!defined(FRAMEWORK_ROOT)) {
    define("FRAMEWORK_ROOT", realpath(dirname(__FILE__)));
}

require_once(FRAMEWORK_ROOT."/library/system/Namespace.class.php");
require_once(FRAMEWORK_ROOT."/library/system/Configuration.class.php");

system_Configuration::LoadFile("framework", FRAMEWORK_ROOT."/framework.config");

if (!defined(APPLICATION_ROOT)) {
    system_Configuration::LoadFile("app", APPLICATION_ROOT."/config/app.config");
    system_Configuration::LoadFile("router", APPLICATION_ROOT."/config/router.config");
    system_Configuration::LoadFile("tasks", APPLICATION_ROOT."/config/tasks.config");
}

?>
