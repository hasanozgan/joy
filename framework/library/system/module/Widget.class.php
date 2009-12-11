<?php

import("system.Configuration");
import("system.module.IWidget");
import("system.web.view.Stack");

class system_module_Widget extends system_web_View implements system_module_IWidget
{
    protected $module;

    public function __construct($module, $widget, $args=array())
    {
        $this->module = $module;
        $this->input = $args;
        parent::__construct($widget);
    }

    public function getFolder()
    {
        return sprintf("%s/control/module/%s/%s", APPLICATION_ROOT, $this->module, $this->name);
    }

    public function getResourceKey()
    {
        return sprintf("%s.%s", $this->module, $this->name);
    }
}

?>
