<?php

import("helloworld.BasePage");
#    import("joy.Todo");

import("joy.web.attributes");
import("helloworld.attributes");

/**
 * @helloworld_attributes_Persistence 
 */  
class TestPage extends helloworld_BasePage
{
    /** 
     * @Authorization(Roles="Admin") 
     */
    public function index()
    {
        echo "home page";
    }

    public function OnPreLoad($obj, $args)
    {
        var_dump("OnPreLoad");
    }

    public function OnLoad($obj, $args)
    {
        var_dump("OnLoad");
    }

    /**
     * @joy_web_attributes_Security
     */ 
    public function get()
    {
        $this->Models->Event;

        var_dump($this->Parameters->Get("code"));
        var_dump($this->Request->QueryString->Get("a"));
        echo "get";
    }
}

?>
