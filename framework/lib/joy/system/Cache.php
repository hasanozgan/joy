<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class joy_system_Cache
{
    public $Global;
    public $Local;

    private static $instance;
 
    public function __construct()
    {
        $config = joy_Configure::getInstance();
        
        $this->Global = using($config->Get("joy.plugins.cache_global"));
        $this->Local = using($config->Get("joy.plugins.cache_local"));

        $cache_servers = $config->GetSection("app.servers.cache.global");
        foreach ($cache_servers as $k=>$v) {
            $server = parse_url($v);
            $this->Global->AddServer($server["host"], $server["port"], ($server["query"] == "persist"));
        }

        if (!$this->Global->Get("test")) {
            $this->Global->Set("test", 182223, 86400);
            var_dump( $this->Global->Get("test"));
        }

        if (!$this->Local->Get("test")) {
            $this->Local->Set("test", 12312399, 86400);
            var_dump( $this->Local->Get("test"));
        }
    }

    static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


}

?>
