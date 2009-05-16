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

abstract class joy_web_Attribute extends joy_Object
{
    protected $page;

    abstract function Execute();

    public function __construct($method)
    {
    }

    public function Run(&$page)
    {
        $this->page = $page;
        if (method_exists($this, "Execute")) {
            $this->Execute();
        }
    }

    public static function Loader()
    {
    }
       
}
 
?>
