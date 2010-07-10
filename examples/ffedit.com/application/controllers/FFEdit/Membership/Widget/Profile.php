<?php

class FFEdit_Membership_Widget_Profile extends FFEdit_Membership_Widget
{
    protected function onInit()
    {
        // Require parameters
        $this->setName("Profile");
        $this->setViewFolder(__FILE__);
    }

    public function onLoad()
    {
    }
}
