<?php

/* (C) 2009 Netology Joy Web Framework v.0.3, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.Object");

class joy_data_Dictionary extends joy_Object
{
    protected $_list;

    public function __construct($array=null)
    {
        parent::__construct();
        $this->_list = $array;
    }

    public function Get($key)
    {
        return $this->_list[$key];
    }

    public function Add($value)
    {
        $this->_list[] = $value; 
    }

    public function Set($key, $value)
    {
        $this->_list[$key] = $value; 
    }

    public function GetAll()
    {
        return $this->_list;
    }
}

?>
