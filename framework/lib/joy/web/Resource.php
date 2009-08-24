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
        //TODO Required View & Meta objects
        if (stripos($file, "?ver=") === false) {
            $uri = $this->Config->Get("app.document_root.folders.uri.script");
            $path = sprintf("%s/%s", $this->Config->Get("app.document_root.folders.path.script"), $file);
            if (!file_exists($path)) return false;

            $file = sprintf("%s/%s?ver=%s", $uri, $file, filemtime($path));
        }

        $this->Scripts->Add($file); 
    }

    public function AddStyle($file)
    {
        //TODO Required View & Meta objects
        if (stripos($file, "?ver=") === false) {
            $uri = $this->Config->Get("app.document_root.folders.uri.style");
            $path = sprintf("%s/%s", $this->Config->Get("app.document_root.folders.path.style"), $file);
            if (!file_exists($path)) return false;

            $file = sprintf("%s/%s?ver=%s", $uri, $file, filemtime($path));
        }

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
