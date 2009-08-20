<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.Object");
import("joy.vendor.Loader");

class joy_security_Encryption extends joy_Object
{
    private $_key;
    private $_encrypter;
    
    protected function Init()
    {
        $loader = new joy_vendor_Loader("security");
        $loader->Import("clsencrypt/clsencrypt.php");

        $this->_encrypter = new Encryption();
    }

    public function encrypt($key, $value)
    {
        return base64_encode($this->_encrypter->encrypt($key, serialize($value)));
    }

    public function decrypt($key, $value)
    {
        return unserialize($this->_encrypter->decrypt($key, base64_decode($value)));
    }
}


?>