<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.Object");
using("joy.web");


class joy_web_HttpContext extends joy_Object
{
    public $Config;
    public $Logger;

    public function __construct()
    {
        $this->Config = joy_Configure::getInstance();
        $this->Logger = joy_Logger::getInstance();
    }
}

?>
