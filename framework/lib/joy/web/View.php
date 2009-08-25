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
import("joy.security.Encryption");

abstract class joy_web_View extends joy_Object 
{
    const LABEL_APP_THEME = "%app.theme%";
    const LABEL_APP_DEFAULT_THEME_FOLDER = "%app.default_theme_folder%";
    
    const LAYOUT = "layout";
    const VIEW = "view";
    const DEFAULT_OUTPUT_MODE = self::LAYOUT;

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

    protected $Meta;
    protected $HttpContext;

    // Abstract Methods
    public abstract function Fetch();
    public abstract function Display();


    protected function Init()
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
        $this->HttpContext =& joy_web_HttpContext::getInstance();
    }

    protected function loadPageResource($output)
    {
        if (in_array($this->Meta->OutputMode, array(joy_web_View::VIEW, joy_web_View::LAYOUT))) {
            if ($this->Meta->Source == "Browser") {
                if ($file = $this->getLayoutFileUri("css")) {
                    joy_web_Resource::getInstance()->AddStyle($file);
                }

                if ($file = $this->getLayoutFileUri("js")) {
                    joy_web_Resource::getInstance()->AddScript($file);
                }
            }

            if ($file = $this->getViewFileUri("css")) {
                joy_web_Resource::getInstance()->AddStyle($file);
            }

            if ($file = $this->getViewFileUri("js")) {
                joy_web_Resource::getInstance()->AddScript($file);
            }
        }

        $output = str_replace("<!-- @@Script.AutoLoad@@ -->", $this->getScriptView(), $output);
        $output = str_replace("<!-- @@Style.AutoLoad@@ -->", $this->getStyleView(), $output);

        return $output;
    }

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
     
        // Script & Style File Loading...
        $this->loadPageResource(&$output);

        // Set Post Filter For Render 
        $this->Event->Dispatch("PostRender", &$output);

        return $output;
    }

    public function setMeta($meta)
    {
        $this->Meta =& $meta;
        $this->setView($this->Meta->Action);
        $this->setViewFolder($this->Meta->Page);
    }

    public function setLayout($name)
    {
        $this->layoutName = $name;    
    }

    public function setView($name)
    {
        $this->viewName = $name;    
    }

    public function setViewFolder($name)
    {
        $this->viewFolderName = $name;
    }

    public function setTheme($theme)
    {
        $this->themeName = $theme;
    }

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    public function getFileThemePath($p_temp, $file)
    {
        $path_temp = sprintf("%s/%s", rtrim($p_temp, "/"), ltrim($file, "/"));

        if ($this->themeName) {
            $theme = $this->themeName;
            $path = str_replace(self::LABEL_APP_THEME, $this->themeName, $path_temp);
            if (!file_exists($path)) {
                $theme = $this->defaultThemeFolder;           
                $path = str_replace(self::LABEL_APP_THEME, $this->defaultThemeFolder, $path_temp);
            }
        }
        else {
            $theme = $this->defaultThemeFolder;           
            $path = str_replace(self::LABEL_APP_THEME, $this->defaultThemeFolder, $path_temp);
        }
        
        if (!file_exists($path)) return false;
        return array($path, $theme);
    }

    public function getScriptView()
    {
        $uri_temp = $this->Config->Get("app.document_root.folders.uri.script");
        $p_temp = $this->Config->Get("app.document_root.folders.path.script");
 
        $scripts = joy_web_Resource::getInstance()->Scripts->GetAll();
        foreach ($scripts as $file) {
            if (stripos($file, "?ver=") === false) {
                 if (!(list($path, $theme) = $this->getFileThemePath($p_temp, $file))) continue;

                 $uri = str_replace(self::LABEL_APP_THEME, $theme, $uri_temp);
                 $file = sprintf("%s/%s?ver=%s", rtrim($uri, "/"), ltrim($file, "/"), filemtime($path));
            }

            $result .= "<script type='text/javascript' src='$file'></script>\n";
        }

        return $result;
    }

    public function getStyleView()
    {
        $uri_temp = $this->Config->Get("app.document_root.folders.uri.style");
        $p_temp = $this->Config->Get("app.document_root.folders.path.style");
 
        $styles = joy_web_Resource::getInstance()->Styles->GetAll();
        foreach ($styles as $file) {

            if (stripos($file, "?ver=") === false) {
                 if (!(list($path, $theme) = $this->getFileThemePath($p_temp, $file))) continue;

                 $uri = str_replace(self::LABEL_APP_THEME, $theme, $uri_temp);
                 $file = sprintf("%s/%s?ver=%s", rtrim($uri, "/"), ltrim($file, "/"), filemtime($path));
            }
            $result .= "<link type='text/css' rel='stylesheet' href='$file' />\n";
        }

        return $result;
    }

    public function getMeta()
    {
        return $this->Meta; 
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function getView()
    {
        return $this->viewName; 
    }

    public function getViewFolder()
    {
        return $this->viewFolderName;
    }

    public function getTheme()
    {
        return $this->themeName;
    }

    public function getViewFileUri($fileExtension="")
    {
        $path = $this->getViewFilePath($fileExtension);
        if (!file_exists($path)) return false;
        
        return sprintf("%s.%s.%s?ver=%s", $this->Meta->PageUri, self::VIEW, $fileExtension, filemtime($path));
    }
 
    public function getViewFilePath($fileExtension="")
    {
        if (empty($fileExtension)) {
            $fileExtension = $this->viewFileExtensionName;
        }

        $view_path = sprintf("%s/%s/%s.%s", 
                                     rtrim($this->viewPath, "/"),
                                     $this->viewFolderName,
                                     $this->viewName,
                                     $fileExtension);

        $theme_folder = $this->getTheme();

        if ($theme_folder) {
            $vpath = str_replace(self::LABEL_APP_THEME, $theme_folder, $view_path);
            if (file_exists($vpath)) {
                return $vpath;
            }
        }

        return str_replace(self::LABEL_APP_THEME, $this->defaultThemeFolder, $view_path);
    }

    public function getLayoutFileUri($fileExtension="")
    {
        $path = $this->getLayoutFilePath($fileExtension);
        if (!file_exists($path)) return false;
        
        return sprintf("%s.%s.%s?ver=%s", $this->Meta->PageUri, self::LAYOUT, $fileExtension, filemtime($path));
    }

    public function getLayoutFilePath($fileExtension="")
    {
        if (empty($fileExtension)) {
            $fileExtension = $this->layoutFileExtensionName;
        }

        $layout_path = sprintf("%s/%s.%s", 
                                     rtrim($this->layoutPath, "/"),
                                     $this->layoutName,
                                     $fileExtension);

        $theme_folder = $this->getTheme();

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
