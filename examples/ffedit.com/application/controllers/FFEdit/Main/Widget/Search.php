<?php

class FFEdit_Main_Widget_Search extends FFEdit_Main_Widget
{
    protected function onInit()
    {
        // Require parameters
        $this->setName("Search");
        $this->setViewFolder(__FILE__);
    }

    public function onLoad()
    {
    }
}
