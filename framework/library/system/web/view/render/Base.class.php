<?php

import("system.Object");
import("system.web.view.render.ITemplateEngine");
import("system.web.view.BlockLoader");
import("system.web.view.Stack");

abstract class system_web_view_render_Base extends system_Object implements system_web_view_render_ITemplateEngine
{
    public $stackRules;
    public $_i18n;
    public $_render;
    public $templateEngine;

    public function Init()
    {
    }

    /**
     * Execute for template engine 
     **/
    public abstract function Execute($filename);

    public function setStackRules($rules)
    {
        $this->stackRules = (array)$rules;
    }

    public function i18n($file)
    {
        if (file_exists($file)) {
            $this->_i18n = parse_ini_file($file);
        }
    }

    protected function preparation()
    {
        $this->_render = array("stack"=>new system_web_view_Stack($this->stackRules),
                               "block"=>new system_web_view_BlockLoader());

        $this->Assign("joy_i18n", $this->_i18n);
        $this->Assign("joy_render", $this->_render);
    }

    public function assign($key, $value)
    {
        $this->templateEngine->$key = $value;
    }

    public function fetch($file)
    {
        $this->preparation();

        return $this->Execute($file);
    }
}

?>
