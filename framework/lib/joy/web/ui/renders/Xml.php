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
import("joy.web.ui.renders.IRender");

class joy_web_ui_renders_Xml extends joy_Object implements joy_web_ui_renders_IRender
{
    private $serializer;
    private $page;

    public function __construct($page)
    {
        parent::__construct();
        $smartyLoader = new joy_vendor_Loader("misc");
        $smartyLoader->Import("xml/class/xmlserialize.cls.php");

        $this->page =& $page;
        $this->page->Response->SetHeader("Content-Type: text/xml");
        $this->serializer = new xmlserialize($this->page, $this->page->Data);
    }

    public function Fetch()
    {
        return $this->serializer->varsToXml();
    }

    public function Display()
    {
        echo $this->Fetch();
    }
}

?>
