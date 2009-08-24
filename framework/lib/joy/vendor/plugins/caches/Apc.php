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

class joy_vendor_plugins_caches_Apc extends joy_vendor_plugins_caches_Base
{
    protected function __vendorAddServer($host, $port, $persist)
    {
    }

    protected function __vendorConnect($host, $port, $persist)
    {
    }

    protected function __vendorGet($key)
    {
        return apc_fetch($key);
    }

    protected function __vendorSet($key, $value, $expire)
    {
        apc_store($key, $value, $expire);
    }

    protected function __vendorDelete($key)
    {
        apc_delete($key);
    }
}


?>
