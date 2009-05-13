<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.plugins.IAttribute");
using("joy.vendors.Loader");

class joy_plugins_attributes_Addendum implements joy_plugins_IAttribute
{
    function __construct()
    {
        $addendum = new joy_vendors_Loader("addendum");
        $addendum->Include("Addendum.class.php");
    }
}


?>
