<?php

/* (C) 2009 Netology Joy Web Framework v.0.3, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.Object");

class joy_data_Dictionary extends joy_Object
{
    protected $list;

    public function __construct($array=null)
    {
        parent::__construct();

        $this->list = $array;
    }

    public function Get($key)
    {
        return $list[$key];
    }

    public function Set($key, $value)
    {
        $list[$key] = $value; 
    }
}

?>
