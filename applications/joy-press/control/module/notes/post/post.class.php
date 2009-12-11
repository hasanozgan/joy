<?php

import("system.module.Widget");

class PostWidget extends system_module_Widget
{
	function OnLoad()
	{
        $post = $this->Models->Posts->getPostBySlug($this->input["post-slug"]);
        $tags = $this->Models->Posts->getTagsByPostId($post->id);
        $categories = $this->Models->Posts->getCategoriesByPostId($post->id);
 
        if (!$post) {
            header("Location: {$this->Config->app["site_root"]}404-not-found");
            die();
        }
      
        $this->output["post"] = $post;
        if (count($tags) > 0) $this->output["tags"] = $tags;
        if (count($categories) > 0) $this->output["categories"] = $categories;
	}
}
?>
