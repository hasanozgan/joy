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
import("joy.web");

class joy_web_ui_RenderFactory extends joy_Object
{
    protected $Theme;
    protected $Layout;
    protected $View;
    protected $ViewFolder;

// {{{ Events 

    public function RegisterEvents()
    {
        parent::RegisterEvents();

        $this->Event->Register("ChangeTheme", "OnChangeTheme", $this);
        $this->Event->Register("ChangeLayout", "OnChangeLayout", $this);
        $this->Event->Register("ChangeView", "OnChangeView", $this);
        $this->Event->Register("ChangeViewFolder", "OnChangeViewFolder", $this);
    }


    public function OnChangeTheme($obj, $args)
    {
        $this->Theme = $args[0];
    }

    public function OnChangeLayout($obj, $args)
    {
        $this->Layout = $args[0];
    }

    public function OnChangeView($obj, $args)
    {
        $this->View = $args[0];
    }

    public function OnChangeViewFolder($obj, $args)
    {
        $this->ViewFolder = $args[0];
    }

// }}}


    public function &Builder($mode)
    {
        $view = $this->ClassLoader($mode);

        if (!$view) {
            throw new Exception("Render class not found");
        }

        if ($this->Theme) {
            $view->setTheme($this->Theme);
        }
        if ($this->Layout) {
            $view->setLayout($this->Layout);
        }
        if ($this->View) {
            $view->setView($this->View);
        }
        if ($this->ViewFolder) {
            $view->setViewFolder($this->ViewFolder);
        }

        return $view;
    }

    public static function GetOutputMode($mode)
    {
        $mode = empty($mode) ? joy_web_View::DEFAULT_OUTPUT_MODE : $mode;
        $namespace = joy_Configure::getInstance()->Get("joy.renders.{$mode}");
        if (!$namespace) {
            $mode = joy_web_View::DEFAULT_OUTPUT_MODE;
        }

        return $mode;
    }
 
    public function ClassLoader($mode)
    {
        $namespace = $this->Config->Get("joy.renders.{$mode}");

        return using($namespace);
    }    
}

?>
