<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.plugins.IORMap");

class joy_plugins_ormaps_Doctrine implements joy_plugins_IORMap
{
    public $dsn;

    function __construct()
    {
        $doctrine = new joy_vendors_Loader("doctrine");
        $doctrine->Include("Doctrine.class.php");
    }
}


?>
