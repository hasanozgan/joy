<?php

import("system.Object");
import("system.web.context.Router");
import("system.web.context.Culture");
import("system.web.context.Request");
import("system.web.context.Response");
import("system.web.context.User");
import("system.web.context.Session");
import("system.web.context.Model");
import("system.web.context.Module");

class system_web_Context extends system_Object
{
    private static $_instance;

    public $Router;
    public $Culture;
    public $Session;
    public $Request;
    public $Response;
    public $User;
    public $Models;
    public $Modules;

    public static function &Instance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    protected function Init()
    {
        parent::Init();

        $this->Router = system_web_context_Router::Instance();
        $this->Culture = system_web_context_Culture::Instance();
        $this->User = system_web_context_User::Instance();
        $this->Request = system_web_context_Request::Instance();
        $this->Response = system_web_context_Response::Instance();
        $this->Session = system_web_context_Session::Instance();
        $this->Models = system_web_context_Model::Instance();
        $this->Modules = system_web_context_Module::Instance();
    }	
}

?>
