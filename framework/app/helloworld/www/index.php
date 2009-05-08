<?php

// generated file by joy script
define("FRAMEWORK_ROOT", "/prj/joy/svn/trunk/framework/");
define("APP_ROOT", "/prj/joy/svn/trunk/framework/app/helloworld/");

require_once(FRAMEWORK_ROOT."bootstrap.php");
joy_Configure::getInstance()->Load(APP_ROOT."config.ini");

using("joy.web.PageFactory");
joy_web_PageFactory::Builder();

?>
