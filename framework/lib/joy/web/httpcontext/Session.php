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

class joy_web_httpcontext_Session extends joy_Object
{
    private $_session;
    private static $instance;

    public static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function Init()
    {
        session_start();
        $this->_session = new joy_data_Dictionary($_SESSION);
    }

    public function Get($key)
    {
        return $this->_session->Get($key);
    }

    public function Set($key, $value)
    {
        $this->_session->Set($key, $value); 
    }
}

?>
