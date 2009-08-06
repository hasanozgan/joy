<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.plugins.IAnnotation");
import("joy.vendor.Loader");

class joy_plugins_annotations_Addendum extends joy_Object implements joy_plugins_IAnnotation
{
    function __construct()
    {
        $addendum = new joy_vendor_Loader("addendum");
        $addendum->Import("annotations.php");
    }

    function GetPageAttributes($page_name)
    {
        $ref = new ReflectionAnnotatedClass($page_name);
        return $ref->getAnnotations();
    }

    function GetActionAttributes($page_name, $action_name) 
    {
        $ref = new ReflectionAnnotatedClass($page_name);
        $r = $ref->getMethod($action_name);

        return $r->getAnnotations();
    }
}


?>
