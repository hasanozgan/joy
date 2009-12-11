<?php

import("system.module.Widget");

class AllWidget extends system_module_Widget
{
	function OnLoad()
	{
        $this->output["posts"] = $this->Models->Posts->getEntryList();
	}
}
?>
