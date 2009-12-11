<?php

import("system.web.View");

class system_web_view_Block extends system_web_View
{
    public function getFolder()
    {
        return sprintf("%s/view/blocks", APPLICATION_ROOT);
    }

    public function getResourceKey()
    {
        return sprintf("block-%s", $this->name);
    }
}

?>
