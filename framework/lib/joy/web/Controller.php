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
    public $View;
    public $Model;
    public $Meta;
    public $Resource;

    protected $Action;
    protected $RenderType;
    protected $Render;
    protected $Parameters;
    protected $Models;
    protected $Output;

    public function Init()
    {
        parent::Init();

        $this->View = new joy_web_View();
        $this->Model = joy_web_Model::getInstance();
        $this->Resource = joy_web_Resource::getInstance();
    }

    protected function RegisterEvents()
    {
        parent::RegisterEvents();

        $this->Event->Register("DBConnection", "OnDBConnection", $this);
        $this->Event->Register("PreRender", "OnPreRender", $this);
        $this->Event->Register("PostRender", "OnPostRender", $this);
    }

    public function setPageMeta($pageMeta)
    {
        $this->Meta =& $pageMeta;
        $this->Request->Parameter = new joy_data_Dictionary($this->Meta->PageArguments);
        $this->View->setRenderType($this->Meta->RenderType);
        $this->View->setViewFile($this->Meta->Action);
        $this->View->setViewFolder($this->Meta->Page);
    }
    
    public function loadAttributes()
    {
        $this->Logger->Debug("Controller::Attributes", __FILE__, __LINE__);

        joy_web_Attribute::Loader(&$this);
    }

    public function runMethod()
    {
        $this->Logger->Debug("Controller::RunMethod (".$this->Action.")", __FILE__, __LINE__);

        $class = new ReflectionClass($this);
        $class->getMethod($this->Meta->Action)->invoke($this, $this->Meta->ActionArguments);
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

    public function render()
    {
        // Pre Render Process...
        $this->Event->Dispatch("PreRender");

        $this->Render = joy_web_ui_RenderFactory::Builder(&$this);
        if (!$this->Render) {
            throw new Exception("Render Not Found");
        }
        $output = $this->Render->Fetch();
      
        $this->Event->Dispatch("PreHeader");
        $this->Event->Dispatch("Render", &$output);
        $this->PageOutput = $output;
    }

    public function complete()
    {
        $this->Event->Dispatch("Unload");
        echo $this->appendTraceLog($this->PageOutput);
    }

}

?>
