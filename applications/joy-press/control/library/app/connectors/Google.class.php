<?php

class Twitter extends Connector
{
    public $consumer_key = 'ac.tivi.st';
    public $consumer_secret = 'TUoZIGZoWUPd2hdPm3L1wdFS';

    public $request_token_url = 'https://twitter.com/oauth/request_token';
    public $access_token_url = 'https://twitter.com/oauth/access_token';
    public $authorize_url = 'https://www.google.com/accounts/AuthSubRequest?scope=http%3A%2F%2Fwww.google.com%2Fcalendar%2Ffeeds%2F&session=1&secure=0&next=http%3A%2F%2Fac.tivi.st%2Fauth%2F6sw6cjb2%2Fgoogle%2F&hd=default';
}
