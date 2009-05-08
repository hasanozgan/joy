<?php

using("helloworld.BasePage");

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
