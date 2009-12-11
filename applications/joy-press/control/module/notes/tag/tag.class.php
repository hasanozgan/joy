<?php

import("system.module.Widget");

class TagWidget extends system_module_Widget
{
	function OnLoad()
	{
        $this->output["tag"]["slug"] = $this->input["tag-slug"];
        $this->output["posts"] = $this->Models->Posts->getEntryListByTagSlug($this->input["tag-slug"]);

        if (!count($this->output["posts"])) {
            header("Location: {$this->Config->app["site_root"]}404-not-found");
            die();
        }
	}
}
?>
