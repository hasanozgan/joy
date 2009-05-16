<?php

using("helloworld.BasePage");
#    using("joy.Todo");

#using("joy.web.Attribute");
#using("joy.web.attributes");
using("helloworld.attributes");
    /** 
     * @Persistence 
     */  
class TestPage extends helloworld_BasePage
{
    public function PreAction()
    {
//        $this->data = 5;
//        echo "Pre Action($action)<br/>";
    }

    public function PostAction()
    {
//        $this->data += 9;
//        echo "Post Action ($action) {$this->data}<br/>";
    }

    /* 
     * @Authorization(Roles="Admin") 
     */
    public function index()
    {
        echo "home page";
    }

    /** 
     * @Persistence 
     */ 
    public function get()
    {
        echo "get";
    }
}

?>
