<?php

class FFEdit_Main_Widget_Membership extends FFEdit_Main_Widget
{
    public function onInit()
    {
        // Require parameters
        $this->setName("Membership");
        $this->setViewFolder(__FILE__);
    }

    public function onLoad()
    {
        $member = $this->session->get("member");

        if (is_array($member)) {
            $ff = FriendFeed_Helper::getInstance();
            $member["logged"] = true;
            $member["picture"] = $ff->fetch_picture($member["username"], array("size"=>"medium"));
            $member["link"] = sprintf("http://friendfeed.com/%s", $member["username"]);
        }
        else {
            $member["logged"] = false;
        }

        $this->assign("member", $member);
    }
}
