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
    protected $RenderType;
    protected $Parameters;
    protected $Models;
    protected $Output;

    public function SetPageMeta($pageMeta)
    {
        $this->Action = $pageMeta->Action;
        $this->ActionArguments = $pageMeta->ActionArguments;
        $this->RenderType = (empty($pageMeta->RenderType) ? "layout" : $pageMeta->RenderType);
        $this->Parameters = new joy_data_Dictionary($pageMeta->PageArguments);
        $this->Models = new joy_web_Model();

        $this->View->SetView($this->Action, $pageMeta->Page);
    }

    public function GetRenderType()
    {
        return $this->RenderType;
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
        $this->Logger->Debug("Controller::LoadAttributes", __FILE__, __LINE__);

        joy_web_Attribute::Loader(&$this);
    }

    public function RunMethod()
    {
        $this->Logger->Debug("Controller::RunMethod (".$this->Action.")", __FILE__, __LINE__);

        $class = new ReflectionClass($this);
        $class->getMethod($this->Action)->invoke($this, $this->ActionArguments);
    }

    private function appendTraceLog($output)
    {
        if (true == ((bool)$this->Config->Get("app.trace.enabled")) && ($this->RenderType == "layout")) {
            $log_output = $this->Logger->Fetch();
            $output = sprintf("%s<hr/><center>T R A C E &nbsp; L O G</center><hr/><small>%s</small>", 
                              $output, $log_output);
        }

        return $output;;
    }

    public function Render()
    {
        $render = joy_web_ui_RenderFactory::Builder(&$this);
        $output = $render->Fetch();
      
        $this->Event->Dispatch("Header");
        $this->Event->Dispatch("Render", &$output);
        $this->PageOutput = $output;
    }

    public function Complete()
    {
        $this->Event->Dispatch("Unload");
        echo $this->appendTraceLog($this->PageOutput);
    }

    protected function RegisterEvents()
    {
        parent::RegisterEvents();

        $this->Event->Register("DBConnection", "OnDBConnection", $this);
    }
}

?>
