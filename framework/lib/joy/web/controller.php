<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.data.Dictionary");
import("joy.web.HttpContext");
import("joy.web.Model");
import("joy.web.Attribute");

class joy_web_Controller extends joy_web_HttpContext
{
    protected $Action;
    protected $Parameters;
    protected $Models;
    protected $Output;

    public function SetPageMeta($pageMeta)
    {
        $this->Action = $pageMeta->Action;
        $this->ActionArguments = $pageMeta->ActionArguments;
        $this->Parameters = new joy_data_Dictionary($pageMeta->PageArguments);
        $this->Models = new joy_web_Model();

        $this->View->SetView($this->Action, $pageMeta->Page);
    }

    public function GetPageName()
    {
        return get_class($this);
    }

    public function GetActionName()
    {
        return $this->Action;
    }

    public function LoadAttributes()
    {
        var_dump("Controller::LoadAttributes"); 

        joy_web_Attribute::Loader(&$this);
    }

    public function RunMethod()
    {
        var_dump("Controller::RunMethod"); 

        $class = new ReflectionClass($this);
        $class->getMethod($this->Action)->invoke($this, $this->ActionArguments);
    }

    public function Render()
    {
        $render = joy_web_ui_RenderFactory::Builder(&$this);
        $output = $render->Fetch();

        $this->Event->Dispatch("Render", &$output);
        print($output);
    }

    protected function RegisterEvents()
    {
        parent::RegisterEvents();

        $this->Event->Register("DBConnection", "OnDBConnection", $this);
    }
}

?>
