<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.system");

class joy_Object
{
    public $Config;
    public $Logger;
    public $Event;
    public $Cache;

    public function __construct()
    {
        $this->Config =& joy_Configure::getInstance();
        $this->Logger =& joy_system_Logger::getInstance();
        $this->Event =& joy_system_Event::getInstance();
        $this->Cache =& joy_system_Cache::getInstance();

        $this->RegisterEvents();
        $this->Init();
    }

    protected function Init()
    {
        // Inheritance
    }

    protected function RegisterEvents()
    {
        // Inheritance
    }
}


?>
