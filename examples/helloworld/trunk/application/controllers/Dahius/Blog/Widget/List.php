<?php

class Dahius_Blog_Widget_List extends Dahius_Blog_Widget
{
    protected function _init()
    {
        parent::_init();

        // Require parameters
        $this->setName("List");
        $this->setViewFolder(__FILE__);
    }

    public function onLoad()
    {
        $this->assign("aa", "testng");
 
    }
}
