<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.Object");
import("joy.plugins.IORMap");
import("joy.vendor.Loader");

class joy_plugins_ormaps_Doctrine extends joy_Object implements joy_plugins_IORMap
{
    public $dsn;

    function __construct()
    {
        parent::__construct();

        $doctrine = new joy_vendor_Loader("doctrine");
        $doctrine->Import("Doctrine.php");
        spl_autoload_register(array("doctrine", "autoload"));

        $dsn_list = $this->Config->GetSection("app.servers.database");
        
        foreach($dsn_list as $dsn) 
        {
            $conn = Doctrine_Manager::connection($dsn);
            if ($conn) {
                $this->Event->Dispatch("DBConnection", $conn);
            }
        }
    }

    function GetTable($table)
    {
        return Doctrine::getTable($table);
    }
}

?>
