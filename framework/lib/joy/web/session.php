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

class joy_web_Session extends joy_Object
{
    private $_session;

    public function __construct()
    {
        parent::__construct();

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
