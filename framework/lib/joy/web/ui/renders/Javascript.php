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
import("joy.security.Encryption");

class joy_web_ui_renders_Javascript extends joy_web_View implements joy_web_ui_renders_IRender
{
    private $serializer;

    protected function Init()
    {
        parent::Init();
        $this->setContentType("application/javascript");
    }

    public function Fetch()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $from = str_replace($this->pageUri, "", $uri);

        if ($this->Meta->OutputModeArguments == joy_web_View::LAYOUT) {
            $path = $this->getLayoutFilePath('js');
        }
        else {
            $path = $this->getViewFilePath('js');
        }
        
        $output = "";
        if (file_exists($path)) {
            $output = file_get_contents($path); 
        }

        return $output;
/*
        $encrypted = $this->HttpContext->Request->Get("v");
        $file_info = array('version'=>12346575765, 
                           'from'=>'layout');
ob_end_clean();        
//return        $encrypted = $ency->encrypt(self::JS_ENCRYPTION_KEY, $file_info);

        return print_r($ency->decrypt(self::ENCRYPTION_KEY, $encrypted), true);*/
    }

    public function Display()
    {
        echo $this->Fetch();
    }
}

?>
