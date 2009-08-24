<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.vendor.plugins.ICache");

abstract class joy_vendor_plugins_caches_Base implements joy_vendor_plugins_ICache
{
    protected $registry;
    protected $prefix;

    function __construct()
    {
        $this->Init();
    }

    function Init()
    {
        $this->prefix = "joy_";
        $this->registry = array();
    }

    function GetRegistry()
    {
        return $this->registry;
    }

    function InsertToRegistry($key, $expire)
    {
        $this->registry[$key] = $expire;
    }

    function RemoveFromRegistry($key)
    {
        unset($this->registry[$key]);
    }

    function Get($key)
    {
        $_key = sprintf("%s%s", $this->prefix, $key);

        return $this->__vendorGet($_key);
    }

    function Set($key, $value, $expire)
    {
        $_key = sprintf("%s%s", $this->prefix, $key);

        $this->InsertToRegistry($key, $expire); 
        $this->__vendorSet($_key, $value, $expire);
    }

    function Delete($key)
    {
        $_key = sprintf("%s%s", $this->prefix, $key);

        $this->RemoveFromRegistry($key); 
        $this->__vendorDelete($_key);
    }

    function AddServer($host, $port=11211, $persist=true)
    {
        $this->__vendorAddServer($host, $port, $persist);
    }

    function Connect($host, $port=11211, $persist=true)
    {
        $this->__vendorConnect($host, $port, $persist);
    }

    abstract protected function __vendorAddServer($host, $port, $persist);
    abstract protected function __vendorConnect($host, $port, $persist);
    abstract protected function __vendorGet($key);
    abstract protected function __vendorSet($key, $value, $expire);
    abstract protected function __vendorDelete($key);
}


?>
