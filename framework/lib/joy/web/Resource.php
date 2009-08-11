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

class joy_web_Resource extends joy_Object
{
    public $Scripts;
    public $Styles;

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
        $this->Scripts = new joy_data_Dictionary();
        $this->Styles = new joy_data_Dictionary();
    }
}

?>
