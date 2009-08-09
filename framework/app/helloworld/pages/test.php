<?php

import("helloworld.BasePage");

/**
 * @helloworld_attributes_TestAttribute 
 * @joy_web_attributes_Layout("test")
 * @joy_web_attributes_Theme("WhiteHouse")
 *@joy_web_attributes_ViewFolder("test") 
 * @joy_web_attributes_Authorization(Roles={"Admin", "Developer"}) 
 */  
class TestPage extends helloworld_BasePage
{
    public function index()
    {
        // var_dump("Home Page");
    }

    public function OnInit($obj, $args)
    {
    //    var_dump("OnInit");
    }

    public function OnLoad($obj, $args)
    {
        $this->Data["page"]="data";
    //    var_dump("OnLoad");
    }

    public function OnRender($obj, $args)
    {
//       $obj = "Joy Web Framework Output".$obj;
    //    var_dump("OnRender");
    }

    public function OnUnload($obj, $args)
    {
    //    var_dump("OnUnload");
    }


    /**
     * @joy_web_attributes_SafeRequest
     * @joy_web_attributes_Theme("BlueMoon")
     * @joy_web_attributes_Layout("test")
     *@joy_web_attributes_ViewFolder("test")
     * @joy_web_attributes_View("get")
     * @joy_web_attributes_Serialization{Renders={"xml","json","view","rdf"})
     */ 
    public function get()
    {
//     $product =  var_dump($this->Models->Products->getById($id));
//     $product->Type
// $this->View->SetTheme("Electronic");
        $this->Data["action"]="data";
//        var_dump($this->Models->User);

        /*
        var_dump($this->Parameters->Get("code"));
        var_dump($this->Request->QueryString->Get("a"));
        */
     //   var_dump("get Action");
    }
}

?>
