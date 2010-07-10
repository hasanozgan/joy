<?php

class FriendFeed_Helper 
{
    public static function getInstance($access_token=null)
    {
        $config = Joy_Config::getInstance();
        $ffParams = $config->application->get("friendfeed");
         
        return new FriendFeed($ffParams["key"], $ffParams["secret"], $access_token);
    }

    public static function getAuthentication()
    {
        $ff = self::getInstance();

        $request_token = $ff->fetch_oauth_request_token();
        $authurl = $ff->get_oauth_authentication_url($request_token);

        return array($request_token, $authurl);
    }
}
