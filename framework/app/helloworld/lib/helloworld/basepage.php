<?php

import("joy.web.ui.Page");
import("helloworld.attributes");

// base page class
class helloworld_BasePage extends joy_web_ui_Page
{
    public function OnDBConnection(&$object, &$args)
    {
        $conn = $object;

        $conn->setCollate('utf8_general_ci');
        $conn->setCharset('utf8');

        $conn->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $conn->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);

        $servers = array(
            'host' => 'localhost',
            'port' => 11211,
            'persistent' => true
        );
        $cacheDriver = new Doctrine_Cache_Memcache(array(
                'servers' => $servers,
                'compression' => false
            )
        );

        $conn->setAttribute(Doctrine::ATTR_QUERY_CACHE, $cacheDriver); 

        $app_root = rtrim($this->Config->Get("app.root"), "/");

        $dal_path = sprintf("%s/%s", $app_root, $this->Config->Get("joy.vendors.doctrine.settings.data_access_layer_dir"));
        $model_path = sprintf("%s/%s", $app_root, $this->Config->Get("joy.vendors.doctrine.settings.model_dir"));
        
        Doctrine::loadModels($dal_path);
        Doctrine::loadModels($model_path);
    }
}

?>
