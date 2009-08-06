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
import("joy.web.ui.RenderFactory");
import("joy.vendor.Loader");

class joy_plugins_templateengines_Tal extends joy_Object implements joy_plugins_ITemplateEngine
{
    private $smarty;

    function __construct()
    {
        parent::__construct();
        $this->data = array();
    }

    public function Fetch($path)
    {
        $smartyLoader = new joy_vendor_Loader("tal");
        $smartyLoader->Import("PHPTAL.php");

        $this->tal = new PHPTAL($path);

        return $this->tal->execute();
    }

    public function Display($path)
    {
        echo $this->Fetch($path);
    }

    public function Assign($key, $value)
    {
        $this->data[$key] = $value;
    }
}


?>
