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
import("joy.web");

class joy_web_ui_RenderFactory extends joy_Object
{
    public static function &Builder($mode)
    {
        $result = self::ClassLoader($mode);

        if (!$result) {
            throw new Exception("Render class not found");
        }

        return $result;
    }

    public static function GetOutputMode($mode)
    {
        $config = joy_Configure::getInstance();

        $mode = empty($mode) ? joy_web_View::DEFAULT_OUTPUT_MODE : $mode;
        $namespace = $config->Get("joy.renders.{$mode}");
        if (!$namespace) {
            $mode = joy_web_View::DEFAULT_OUTPUT_MODE;
        }

        return $mode;
    }
 
    public static function ClassLoader($mode)
    {
        $config = joy_Configure::getInstance();
    
        $namespace = $config->Get("joy.renders.{$mode}");

        //TODO: Assign View Class
        return using($namespace);
    }    
}

?>
