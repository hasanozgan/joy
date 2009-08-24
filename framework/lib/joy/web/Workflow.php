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

class joy_web_Workflow extends joy_Object
{
    private static $_instance;

    public static function getInstance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function Process($activity) 
    {
        if (is_bool($activity)) {
            $activity = ($activity ? "success" : "fail");
        }

        //TODO: Got To Process
        var_dump(sprintf("Workflow Engine: Activity=> %s", $activity));
    }
}
