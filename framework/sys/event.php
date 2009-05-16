<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class joy_Event 
{
    private $values;
    private static $instance;
  
    static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new joy_Event();
        }

        return self::$instance;
    }

    public function Register($name, $method, $class=null)
    {
    }

    public function UnRegister($name, $method, $class=null)
    {
    }

    public function Dispatch($name)
    {
    }
}

?>
