<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.vendor.plugins.caches.Base");
import("joy.vendor.Loader");

class joy_vendor_plugins_caches_Memcached extends joy_vendor_plugins_caches_Base
{
    protected $memcached;

    public function Init()
    {
        parent::Init();
        $this->memcached = new Memcache();
    }

    protected function __vendorAddServer($host, $port, $persist)
    {
        $this->memcached->addServer($host, $port, $persist);
    }

    protected function __vendorConnect($host, $port, $persist)
    {
        if ($persist) 
            $this->memcached->pconnect($host, $port);
        else 
            $this->memcached->connect($host, $port);
    }

    protected function __vendorGet($key)
    {
        return $this->memcached->get($key);
    }

    protected function __vendorSet($key, $value, $expire)
    {
        $this->memcached->set($key, $value, 0, $expire);
    }

    protected function __vendorDelete($key)
    {
        $this->memcached->delete($key);
    }
}


?>
