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

class joy_web_View extends joy_Object
{
    protected $viewName;
    protected $viewFolderName;
    protected $themeName;
    protected $themeFolderName;
    protected $outputMode;
    protected $render;
    protected $data;

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
    }

    public function RegisterEvents()
    {
        parent::RegisterEvents();
    }

    public function render()
    {
    
    }

    public function setViewFile($name)
    {
    
    }

    public function setViewFolder($name)
    {
    
    }

    public function setRenderType($type)
    {
    
    }

    public function getViewFile()
    {
    
    }

    public function getViewFolder()
    {
    
    }

    public function getRenderType()
    {
    
    }



}

?>
