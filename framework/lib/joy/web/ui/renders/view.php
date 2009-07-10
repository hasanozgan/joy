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
import("joy.web.ui.renders.IRender");

class joy_web_ui_renders_View extends joy_Object implements joy_web_ui_renders_IRender
{
    public function Fetch()
    {
        return "View";
    }

    public function Display()
    {
        echo "View";
    }

}

?>
