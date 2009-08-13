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
import("joy.web.ui.RenderFactory");

class joy_web_View extends joy_Object 
{
    const LABEL_APP_THEME = "%app.theme%";
    const LABEL_APP_DEFAULT_THEME_FOLDER = "%app.default_theme_folder%";

    protected $viewPath;
    protected $viewName;
    protected $viewFolderName;
    protected $viewFileExtensionName;
    
    protected $themeName;
    protected $themeFolderName;
    protected $defaultThemeFolder;
    
    protected $layoutPath;
    protected $layoutName;
    protected $layoutFileExtensionName;

    protected $data;
    protected $contentType;

    protected $HttpContext;

    private static $instance;

    public static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function Init()
    {
        parent::Init();

        $this->contentType = "text/html";
        $this->data = array();
        $this->defaultThemeFolder = $this->Config->Get("app.default_theme_folder");
        $this->viewFileExtensionName = $this->Config->Get("joy.extensions.view");
        $this->layoutFileExtensionName = $this->Config->Get("joy.extensions.layout");
        $this->themeName = $this->Config->Get("app.theme");
        $this->viewPath = $this->Config->Get("app.folders.path.view");
        $this->layoutPath = $this->Config->Get("app.folders.path.layout");

        // Get HttpContext Instance...
        $this->HttpContext = joy_web_HttpContext::getInstance();
    }

    public function RegisterEvents()
    {
        parent::RegisterEvents();

        $this->Event->Register("ChangeTheme", "OnChangeTheme", $this);
        $this->Event->Register("ChangeLayout", "OnChangeLayout", $this);
        $this->Event->Register("ChangeView", "OnChangeView", $this);
        $this->Event->Register("ChangeViewFolder", "OnChangeViewFolder", $this);
    }

// {{{ Events 

    public function OnChangeTheme($obj, $args)
    {
        $name = $args[0];
        $this->setThemeName($name);
    }

    public function OnChangeLayout($obj, $args)
    {
        $name = $args[0];
        $this->setLayoutFile($name);
    }

    public function OnChangeView()
    {
        $name = $args[0];
        $this->setViewFile($name);
    }

    public function OnChangeViewFolder()
    {
        $name = $args[0];
        $this->setViewFolder($name);
    }

// }}}

    public function render()
    {
        // Set Content Type
        $this->HttpContext->Response->SetHeader(sprintf("Content-Type: %s", $this->getContentType()));

        // Set Pre Filter For Render 
        $this->Event->Dispatch("PreRender");

        // From Render Class
        if (method_exists($this, "Fetch")) {
            $output = $this->Fetch();
        }
      
        // Set Post Filter For Render 
        $this->Event->Dispatch("PostRender", &$output);

        // Set Pre Header
        $this->Event->Dispatch("PreHeader");

        return $output;
    }

    public function setLayoutFile($name)
    {
        $this->layoutName = $name;    
    }

    public function setViewFile($name)
    {
        $this->viewName = $name;    
    }

    public function setViewFolder($name)
    {
        $this->viewFolderName = $name;
    }

    public function setThemeName($theme)
    {
        $this->themeName = $theme;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function getViewFile()
    {
        return $this->viewName; 
    }

    public function getViewFolder()
    {
        return $this->viewFolderName;
    }

    public function getThemeName()
    {
        return $this->themeName;
    }

    public function getViewFilePath()
    {
        $view_path = sprintf("%s/%s/%s.%s", 
                                     rtrim($this->viewPath, "/"),
                                     $this->viewFolderName,
                                     $this->viewName,
                                     $this->viewFileExtensionName);

        $theme_folder = $this->getThemeName();

        if ($theme_folder) {
            $vpath = str_replace(self::LABEL_APP_THEME, $theme_folder, $view_path);
            if (file_exists($vpath)) {
                return $vpath;
            }
        }

        return str_replace(self::LABEL_APP_THEME, $this->defaultThemeFolder, $view_path);
    }

    public function getLayoutFilePath()
    {
        $layout_path = sprintf("%s/%s.%s", 
                                     rtrim($this->layoutPath, "/"),
                                     $this->layoutName,
                                     $this->layoutFileExtensionName);

        $theme_folder = $this->getThemeName();

        if ($theme_folder) {
            $lpath = str_replace(self::LABEL_APP_THEME, $theme_folder, $layout_path);
            if (file_exists($lpath)) {
                return $lpath;
            }
        }

        return str_replace(self::LABEL_APP_THEME, $this->defaultThemeFolder, $layout_path);
    }

    public function resetData()
    {
        $this->data = array();
    }

    public function appendData($pData)
    {
        $this->data = array_merge((array)$this->data, (array)$pData);
    }

    public function setData($pData)
    {
        $this->data = $pData;
    }

    public function getData()
    {
        return $this->data;
    }

/*
 * TODO: TraceLog
    private function appendTraceLog($output)
    {
        if (true == ((bool)$this->Config->Get("app.trace.enabled")) && 
            (in_array($this->RenderType, array(joy_web_ui_RenderFactory::LAYOUT, joy_web_ui_RenderFactory::VIEW)))) {
            $log_output = $this->Logger->Output();
            $output .= $log_output;
        }

        return $output;
    }
*/


}

?>
