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
    const JS_ENCRYPTION_KEY = "i love you baby";

    public function Init()
    {
        parent::Init();
        $this->setContentType("application/javascript");
    }

    public function Fetch()
    {
        $encrypted = $this->HttpContext->Request->Get("v");
        $ency = new joy_security_Encryption();

        return $ency->decrypted(self::JS_ENCRYPTION_KEY, $encrypted);
    }

    public function Display()
    {
        echo $this->Fetch();
    }
}

?>
