<?php

using("helloworld.BasePage");

#using("joy.web.Attribute");
#using("joy.web.attributes");
using("helloworld.attributes");

class TestPage extends helloworld_BasePage
{
    public $data;

    public function PreAction($action)
    {
//        $this->data = 5;
//        echo "Pre Action($action)<br/>";
    }

    public function PostAction($action)
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

    public function get()
    {
        echo "get";
    }
}

?>
