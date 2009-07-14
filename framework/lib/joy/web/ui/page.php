<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.web.Controller");
import("joy.web.ui.IPage");
import("joy.web.attributes");

class joy_web_ui_Page extends joy_web_Controller implements joy_web_ui_IPage
{
    private $nameLayoutFile;
    private $nameLayoutFileExtension;

    private $nameViewFile;
    private $nameViewFileExtension;
    private $nameViewFolder;

    private $nameTheme;

    public function __construct()
    {
        parent::__construct();
        //TODO: Themes Folders..

        $this->SetViewFileExtensionName($this->Config->Get("joy.extensions.view"));
        $this->SetLayoutFileExtensionName($this->Config->Get("joy.extension.layout"));
        $this->SetThemeName($this->Config->Get("app.theme"));
        $this->SetViewFolderName(get_class($this));

        $this->Event->Dispatch("Init"); 
        $this->Event->Dispatch("Load");
    }

    public function SetViewFileExtensionName($name)
    {
        $this->nameViewFileExtension = $name;
    }

    public function GetViewFileExtensionName()
    {
        return $this->nameViewFileExtension;
    }

    public function SetViewFileName($name)
    {
        $this->nameViewFile = str_replace(".{$this->nameViewFileExtension}", "", $name);
    }

    public function GetViewFileName()
    {
        return $this->nameViewFile;
    }

    public function SetLayoutFileName($name)
    {
        $this->nameLayoutFile = str_replace(".{$this->nameLayoutFileExtension}", "", $name);
    }

    public function GetLayoutFileName()
    {
        return $this->nameLayoutFile;
    }

    public function SetLayoutFileExtensionName($name)
    {
        $this->nameLayoutFileExtension = $name;
    }

    public function GetLayoutFileExtensionName()
    {
        return $this->nameLayoutFileExtension;
    }

    public function SetViewFolderName($name)
    {
        $this->nameViewFolder = $name;
    }

    public function GetViewFolderName()
    {
        return $this->nameViewFolder;
    }

    public function SetThemeName($name)
    {
        $this->nameTheme = $name;
    }

    public function GetThemeName()
    {
        return $this->nameTheme;
    }

    protected function RegisterEvents()
    {
        parent::RegisterEvents();

        $this->Event->Register("Init", "OnInit", $this);
        $this->Event->Register("Load", "OnLoad", $this);
        $this->Event->Register("Render", "OnRender", $this);
        $this->Event->Register("Unload", "OnUnload", $this);
        $this->PageEvents();
    }

    protected function PageEvents()
    {
        //TODO: Your Events...
    }

    public function OnInit(&$object, &$args)
    {
    }

    public function OnLoad(&$object, &$args)
    {
    }

    public function OnRender(&$object, &$args)
    {
    }

    public function OnUnload(&$object, &$args)
    {
    }
}

?>
