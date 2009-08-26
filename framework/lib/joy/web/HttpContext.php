<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.Object");
import("joy.web.httpcontext");

class joy_web_HttpContext extends joy_Object
{
    public $Request;
    public $Response;
    public $Session;
    public $Cookie;
    public $Server;
    public $Culture; // Localization & Globalization Class
    public $User; //Default Anonymous

    private static $_httpContext;

    public static function getInstance()
    {
        if (!is_object(self::$_httpContext)) {
            self::$_httpContext = new self();
        }

        return self::$_httpContext;
    }

    protected function Init()
    {
        $this->Request = joy_web_httpcontext_Request::getInstance();
        $this->Response = joy_web_httpcontext_Response::getInstance();
        $this->Session = joy_web_httpcontext_Session::getInstance();
        $this->Cookie = joy_web_httpcontext_Cookie::getInstance();
        $this->Server = joy_web_httpcontext_Server::getInstance();
        $this->User = joy_web_httpcontext_User::getInstance();
    }
}

?>
