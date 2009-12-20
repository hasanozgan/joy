<?php

class Dahius_Blog_Widget_List extends Dahius_Blog_Widget
{
    public function __construct()
    {
        $this->setName("List");
        $this->setViewFolder(__FILE__);

        $this->assign("aa", "testng");

//        var_dump($this->getResourceList());
        var_dump($this);
    }
}
