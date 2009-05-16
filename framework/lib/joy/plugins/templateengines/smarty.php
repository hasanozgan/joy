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
using("joy.plugins.ITemplateEngine");

class joy_plugins_templateengines_Smarty extends joy_Object implements joy_plugins_ITemplateEngine
{
    function __construct()
    {
        $smarty = new joy_vendors_Loader("smarty");
        $smarty->Include("Smarty.inc.php");
    }
}


?>
