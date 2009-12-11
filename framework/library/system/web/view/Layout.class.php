<?php

import("system.web.view.Stack");
import("system.web.view.Block");
import("system.web.View");

class system_web_view_Layout extends system_web_View
{
    protected function getFolder()
    {
         return sprintf("%s/view/layouts", APPLICATION_ROOT);
    }

    protected function getResourceKey()
    {
         return sprintf("%s/view/layouts", $this->name);
    }
}

?>
