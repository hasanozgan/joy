<?php

import("helloworld.BasePage");
#    import("joy.Todo");

#import("joy.web.Attribute");
#import("joy.web.attributes");
import("helloworld.attributes");

/** 
 * @Persistence 
 */  
class TestPage extends helloworld_BasePage
{
    /* 
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
     * @Security
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
