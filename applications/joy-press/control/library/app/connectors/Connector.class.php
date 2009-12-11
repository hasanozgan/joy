<?php

abstract class Connector
{
    public $consumer_key;
    public $consumer_secret;

    public $request_token_url;
    public $access_token_url;
    public $authorize_url;

    protected $_request_key;
    protected $_request_secret;

    protected $_access_key;
    protected $_access_secret;

    public function getRequestToken()
    {   
    }

    public function getAccessToken()
    {     
    }

    public function getUserInfo()
    {
    }
}
