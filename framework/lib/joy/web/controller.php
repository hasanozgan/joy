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
import("joy.web.ui.RenderFactory");
import("joy.web.ui.renders.Layout");


class joy_web_Controller extends joy_web_HttpContext
{
    protected $Action;
    protected $RenderType;
    protected $Render;
    protected $Parameters;
    protected $Models;
    protected $Output;

    public function SetPageMeta($pageMeta)
    {
        $this->Action = $pageMeta->Action;
        $this->ActionArguments = $pageMeta->ActionArguments;
        $this->RenderType = (empty($pageMeta->RenderType) ? joy_web_ui_RenderFactory::LAYOUT : $pageMeta->RenderType);
        $this->Parameters = new joy_data_Dictionary($pageMeta->PageArguments);
        $this->Models = new joy_web_Model();
        $this->SetViewFileName($this->Action);
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
        if (true == ((bool)$this->Config->Get("app.trace.enabled")) && 
            (in_array($this->RenderType, array(joy_web_ui_RenderFactory::LAYOUT, joy_web_ui_RenderFactory::VIEW)))) {
            $log_output = $this->Logger->Output();
            $output .= $log_output;
        }

        return $output;
    }

    public function Render()
    {
        $this->Render = joy_web_ui_RenderFactory::Builder(&$this);
        if (!$this->Render) {
            throw new Exception("Render Not Found");
        }
        $output = $this->Render->Fetch();
      
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
