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
import("joy.plugins.ITemplateEngine");

class joy_plugins_templateengines_Smarty extends joy_Object implements joy_plugins_ITemplateEngine
{
    private $smarty;

    function __construct()
    {
        // TODO: Find Smarty Folders...
        $smartyLoader = new joy_vendors_Loader("smarty");
        $smartyLoader->Import("Smarty.class.php");

        // Set smarty parameters app.vendors.smarty.settings section in config.ini file

        $this->smarty = new Smarty();
        $this->smarty->left_delimeter = "{%";
        $this->smarty->right_delimeter = "%}";
        $this->smarty->compile_dir = $compile_dir;
        $this->smarty->template_dir = $template_dir;
        $this->smarty->plugins_dir[] = $plugins_dir;
    }

    public function Fetch()
    {
        return $this->smarty->fetch();
    }

    public function Display()
    {
        return $this->smarty->display();
    }
}


?>
