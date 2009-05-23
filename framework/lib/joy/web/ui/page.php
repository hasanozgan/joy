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

class joy_web_ui_Page extends joy_web_Controller implements joy_web_ui_IPage
{
    public function __construct()
    {
        parent::__construct();

        $this->Event->Dispatch("PreLoad"); 
        $this->Event->Dispatch("Load");
    }

    protected function RegisterEvents()
    {
        parent::RegisterEvents();

        $this->Event->Register("PreLoad", "OnPreLoad", $this);
        $this->Event->Register("Load", "OnLoad", $this);
        $this->Event->Register("Render", "OnRender", $this);

        $this->PageEvents();
    }

    protected function PageEvents()
    {
        //TODO: Your Events...
    }

    public function OnPreLoad(&$object, &$args)
    {
    }

    public function OnLoad(&$object, &$args)
    {
    }

    public function OnRender(&$object, &$args)
    {
    }
}

?>
