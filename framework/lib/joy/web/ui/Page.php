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
    private $nameDefaultThemeFolder;

    public function __construct()
    {
        parent::__construct();
        $this->Data = array();

        $this->SetDefaultThemeFolder($this->Config->Get("app.default_theme_folder"));
        $this->SetViewFileExtensionName($this->Config->Get("joy.extensions.view"));
        $this->SetLayoutFileExtensionName($this->Config->Get("joy.extensions.layout"));
        $this->SetThemeName($this->Config->Get("app.theme"));
        $this->SetViewFolderName(get_class($this));
    }

    public function DispatchEvents()
    {
        $this->Event->Dispatch("Init"); 
        $this->Event->Dispatch("Load");
    }

    public function GetViewFilePath()
    {
        $view_path = sprintf("%s/%s/%s.%s", 
                                     rtrim($this->Config->Get("app.folders.path.view"), "/"),
                                     $this->GetViewFolderName(),
                                     $this->GetViewFileName(),
                                     $this->GetViewFileExtensionName());

        $theme_folder = $this->GetThemeName();

        if ($theme_folder) {
            $vpath = str_replace("%theme%", $theme_folder, $view_path);
            if (file_exists($vpath)) {
                return $vpath;
            }
        }

        $default_theme_folder = $this->GetDefaultThemeFolder();
        return str_replace("%app.theme%", $default_theme_folder, $view_path);
    }

    public function GetLayoutFilePath()
    {
        $layout_path = sprintf("%s/%s.%s", 
                                     rtrim($this->Config->Get("app.folders.path.layout"), "/"),
                                     $this->GetLayoutFileName(),
                                     $this->GetLayoutFileExtensionName());

        $theme_folder = $this->GetThemeName();

        if ($theme_folder) {
            $lpath = str_replace("%app.theme%", $theme_folder, $layout_path);
            if (file_exists($lpath)) {
                return $lpath;
            }
        }

        $default_theme_folder = $this->GetDefaultThemeFolder();
        return str_replace("%app.theme%", $default_theme_folder, $layout_path);
    }

    public function SetDefaultThemeFolder($name)
    {
        $this->nameDefaultThemeFolder = $name;
    }

    public function GetDefaultThemeFolder()
    {
        return $this->nameDefaultThemeFolder;
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
