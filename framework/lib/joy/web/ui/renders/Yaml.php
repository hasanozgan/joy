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

class joy_web_ui_renders_Yaml extends joy_web_View
{
    private $serializer;

    protected function Init()
    {
        parent::Init();
        $this->setContentType("application/x-yaml");
    }

    public function Fetch()
    {
        $loader = new joy_vendor_Loader("misc");
        $loader->Import("yaml/spyc-0.4.2/spyc.php");
        return Spyc::YAMLDump($this->getData());
    }

    public function Display()
    {
        echo $this->Fetch();
    }
}

?>
