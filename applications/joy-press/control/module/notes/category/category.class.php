<?php

import("system.module.Widget");

class TagWidget extends system_module_Widget
{
	function OnLoad()
	{
        $this->output["category"]["slug"] = $this->input["category-slug"];
        $this->output["posts"] = $this->Models->Posts->getEntryListByCategorySlug($this->input["category-slug"]);
        
        if (!count($this->output["posts"])) {
            header("Location: {$this->Config->app["site_root"]}404-not-found");
            die();
        }
	}
}
?>
