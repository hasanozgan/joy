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
import("joy.web.ui.RenderFactory");
import("joy.vendor.Loader");
import("joy.vendor.plugins.ITemplateEngine");

class joy_vendor_plugins_templateengines_Tal extends joy_Object implements joy_vendor_plugins_ITemplateEngine
{
    private $tal;

    function __construct()
    {
        parent::__construct();
        $this->data = array();
        $talLoader = new joy_vendor_Loader("tal");
        $talLoader->Import("PHPTAL.php");

        $this->tal = new PHPTAL();
        $this->tal->setPreFilter(using("vendors.phptal.filters.PreFilter"));
        $this->tal->setPostFilter(using("vendors.phptal.filters.PostFilter"));

        $framework_root = rtrim($this->Config->Get("joy.root"), "/");
        $app_root = rtrim($this->Config->Get("app.root"), "/");

        $plugin_dirs[] = sprintf("%s/%s", $framework_root, $this->Config->Get("joy.vendors.tal.settings.joy_modifiers_dir"));
        $plugin_dirs[] = sprintf("%s/%s", $app_root, $this->Config->Get("joy.vendors.tal.settings.app_modifiers_dir"));

        foreach ($plugin_dirs as $path) {
            if ($dh = opendir($path)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file == "." || $file == "..") continue;

                    list($filename, $ext) = explode(".",$file);
                    if (in_array($ext, array(CLASS_EXTENSION))) {
                        $file = sprintf("%s%s%s", rtrim($path, DIRECTORY_SEPARATOR), 
                                        DIRECTORY_SEPARATOR, 
                                        ltrim($file, DIRECTORY_SEPARATOR));
                        require_once($file);
                    }
                }
                closedir($dh);
            }
        }
    }

    public function Fetch($path)
    {
        $this->tal->setTemplate($path); 
        return $this->tal->execute();
    }

    public function Display($path)
    {
        echo $this->Fetch($path);
    }

    public function Assign($key, $value)
    {
        $this->tal->$key = $value;
    }
}


?>
