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
import("joy.web.attributes");

class joy_web_ui_Page extends joy_web_Controller implements joy_web_ui_IPage
{
    protected function RegisterEvents()
    {
        parent::RegisterEvents();

        $this->Event->Register("Init", "OnInit", $this);
        $this->Event->Register("DBConnection", "OnDBConnection", $this);
        $this->Event->Register("Load", "OnLoad", $this);
        $this->Event->Register("PreRender", "OnPreRender", $this);
        $this->Event->Register("PostRender", "OnPostRender", $this);
        $this->Event->Register("PreHeader", "OnPreHeader", $this);
        $this->Event->Register("Disposal", "OnDisposal", $this);
        $this->PageEvents();
    }

    public function DispatchEvents()
    {
        $this->Event->Dispatch("Init"); 
        $this->Event->Dispatch("Load");
    }

    protected function PageEvents()
    {
        //TODO: Your Events...
    }

    public function OnInit(&$object, &$args)
    {
        // You dont be writing output buffer in classes!.. 
        //ob_start();
    }

    public function OnLoad(&$object, &$args)
    {
    }

    public function OnPreRender(&$object, &$args)
    {
    }

    public function OnPostRender(&$object, &$args)
    {
    }

    public function OnPreHeader(&$object, &$args)
    {
    }

    public function OnDisposal(&$object, &$args)
    {
        //ob_end_clean();
    }
}

?>
