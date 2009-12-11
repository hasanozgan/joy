<?php

import("system.module.Widget");

class IndexWidget extends system_module_Widget
{
	function OnLoad()
	{
        $this->output["last_posts"] = $this->Models->Posts->getLastEntryList();
	}
}
?>
