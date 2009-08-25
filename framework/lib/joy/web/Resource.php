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

class joy_web_Resource extends joy_Object
{
    public $Scripts;
    public $Styles;
    public $Locales;

    private static $instance;

    public static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    protected function Init()
    {
        $this->Locales = new joy_data_Dictionary();
        $this->Scripts = new joy_data_Dictionary();
        $this->Styles = new joy_data_Dictionary();
    }

    protected function RegisterEvents()
    {
        $this->Event->Register("ImportJS", "OnImportJS", $this);
        $this->Event->Register("ImportCSS", "OnImportCSS", $this);
    }

    public function AddScript($file)
    {
        $this->Scripts->Add($file); 
    }

    public function AddStyle($file)
    {
        $this->Styles->Add($file); 
    }

    public function OnImportJS($object, $args)
    {
        $this->AddScript($args[0]);
    }

    public function OnImportCSS($object, $args)
    {
         $this->AddStyle($args[0]); 
    }
}

?>
