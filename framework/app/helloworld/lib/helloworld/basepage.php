<?php

import("joy.web.ui.Page");

// base page class
class helloworld_BasePage extends joy_web_ui_Page
{
    public function OnConnection(&$object, &$args)
    {
        var_dump("OnConnection");
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

        $model_path = $this->Config->Get("app.folders.path.model");
        $dal_path = $this->Config->Get("app.folders.path.data_access_layer");

        Doctrine::loadModels($dal_path);
        Doctrine::loadModels($model_path);
    }
}

?>
