<?php

import("system.Object");
import("system.web.view.Block");

class system_web_view_BlockLoader extends system_Object
{
    public function __get($name)
    {
        $block = new system_web_view_Block($name);
        return $block->build();
    }

    public function request()
    {
        $info = system_web_context_Request::Instance()->getInfo();
        $module = system_module_Factory::Load($info->module);
        return $module->widget($info->action, $info->parameters);
    }

}

?>
