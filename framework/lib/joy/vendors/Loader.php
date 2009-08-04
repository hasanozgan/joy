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

class joy_vendors_Loader extends joy_Object
{
    public $path;

    function __construct($name)
    {
        parent::__construct();

        $this->path = $this->Config->Get("joy.vendors.path.{$name}");
        $this->path = rtrim($this->path, "/");

        set_include_path(get_include_path().PATH_SEPARATOR.$this->path);
    }   

    public function Import($file) 
    {
        $file = ltrim($file, "/");
        require_once(sprintf("%s/%s", $this->path, $file));
    }
}

?>
