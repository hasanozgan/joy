<?php

class FFEdit_Main_Widget_Menu extends FFEdit_Main_Widget
{
    public function onInit()
    {
        // Require parameters
        $this->setName("Menu");
        $this->setViewFolder(__FILE__);
    }

    public function onLoad()
    {
        $locale = $this->getLocale();
        $items = array( "users", "groups" );
        $action = $this->request->getAction();
        $site_root = $this->config->application->get("application/site_root");

        $menu = array();       
        foreach ($items as $item) {
            $menu[] = array("class"=> (($action->parameters["type"] == $item) ? "current" : "no"),
                            "title"=>$locale[$item],
                            "link"=>"$site_root/{$action->parameters["id"]}/$item");
        }

        $this->assign("menuItems", $menu);
    }
}
