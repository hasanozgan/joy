<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.web.View");
import("joy.web.ui.renders.IRender");

class joy_web_ui_renders_Stylesheet extends joy_web_View implements joy_web_ui_renders_IRender
{
    private $serializer;

    protected function Init()
    {
        parent::Init();
        $this->setContentType("text/css");
    }

    public function Fetch()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $from = str_replace($this->pageUri, "", $uri);

        if ($this->Meta->OutputModeArguments == joy_web_View::LAYOUT) {
            $path = $this->getLayoutFilePath('css');
        }
        else {
            $path = $this->getViewFilePath('css');
        }
        
        $output = "";
        if (file_exists($path)) {
            $output = file_get_contents($path); 
        }

        return $output;
    }

    public function Display()
    {
        echo $this->Fetch();
    }
}

?>
