<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class joy_Object
{
    public $Config;
    public $Logger;
    public $Event;

    public function __construct()
    {
        $this->Config =& joy_Configure::getInstance();
        $this->Logger =& joy_Logger::getInstance();
        $this->Event =& joy_Event::getInstance();
        $this->RegisterEvents();
    }

    protected function RegisterEvents()
    {
        //TODO ...
    }
}


?>
