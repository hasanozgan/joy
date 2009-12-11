<?php

import("system.Object");

class system_module_Canvas extends system_Object
{
    // Request Type
    const RT_ACTION = "action",
          RT_WINDGET = "widget";

    private $_arguments;

    public function __construct($module_name) 
    {
        $canvas_file = sprintf("%s/control/canvas/%s.canvas", APPLICATION_ROOT, $module_name);

        if (file_exists($canvas_file)) {
            $config =& system_Configuration::Instance();
            $config->LoadFile("canvas", $canvas_file);

            $this->_arguments = $config->canvas[$module_name];
        }
        else {
            throw new Exception("Canvas file not found");
        }
    }

    public function getWidget($name)
    {
        return $this->loadParameters($name, "widget");
    }

    public function getAction($name)
    {
        return $this->loadParameters($name, "action");
    }

    protected function loadParameters($name, $type)
    {
        $section = ($type == "widget") ? "widgets" : "actions";
        $params = $this->_arguments[$section][$name];
        
        $result = new stdClass();
        $result->layout = ($params["layout"] == null) ? $this->_arguments["layout"] : $params["layout"];
        $result->hasLayout = (($result->layout == null || $result->layout == "none") ? false : !empty($result->layout));
   
        $result->theme = ($params["theme"] == null) ? $this->_arguments["theme"] : $params["theme"];
        if (!$result->theme) {
            $result->theme = $this->Config->app["theme"]; // set default theme
        }

        $result->page = ($params["page"] == null) ? $this->_arguments["page"] : $params["page"];
        if (!$result->page) {
            $result->page = "system.web.ui.Page";
        }

        $roles = ($params["roles"] == null) ? $this->_arguments["roles"] : $params["roles"];
        $has_authentication = (($result->roles == null) ? false : !empty($result->roles));
        
        $result->isAuthenticated = ($has_authentication) 
                                        ? system_web_Context::Current()->User->IsAuthenticated($roles)
                                        : true;

        return $result;
    }
}

?>
