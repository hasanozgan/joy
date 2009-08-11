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
    const LAYOUT="layout";
    const VIEW="view";
    const PLACE_HOLDER_MARKER = "{* __PLACE_HOLDER__ *}";

    public static function Builder($page)
    {
        if ($page instanceof joy_web_ui_IPage) {
            $renderType = $page->Meta->RenderType;
            return self::ClassLoader($renderType, &$page);
        }

        return null;
    }

    public static function ClassLoader($type, $page)
    {
        $config = joy_Configure::getInstance();
       
        if (!($namespace = $config->Get("joy.renders.{$type}"))) {
            $namespace = $config->Get("joy.renders.layout");
        }

        return using($namespace, &$page);
    }    
}

?>
