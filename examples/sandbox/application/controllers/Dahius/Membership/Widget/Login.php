<?php

class Dahius_Membership_Widget_Login extends Dahius_Membership_Widget
{
    protected function _init()
    {
        parent::_init();

        // Require parameters
        $this->setName("Login");
        $this->setViewFolder(__FILE__);
    }

    public function onLoad()
    {
    }
}
