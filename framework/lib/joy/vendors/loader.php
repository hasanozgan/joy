<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class joy_vendors_Loader
{
    public $path;

    function __construct($name)
    {
        $this->path = joy_Logger::getInstance()->Get("joy.vendors.{$name}");
        $this->path = rtrim($this->path, "/");

        set_include_path(get_include_path().PATH_SEPARATOR.$this->path);
    }   

    public function Include($file) 
    {
        $file = ltrim($file, "/");
        require_once(sprintf("%s/%s", $this->path, $file));
    }
}

?>
