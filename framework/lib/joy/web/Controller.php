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
    public $Model;
    public $View;
    public $Meta;
    public $Workflow;
    public $Resource;

    protected function Init()
    {
        parent::Init();

        $this->RenderFactory = new joy_web_ui_RenderFactory();
        $this->Model = joy_web_Model::getInstance();
        $this->Resource = joy_web_Resource::getInstance();
        $this->Workflow = joy_web_Workflow::getInstance();
    }

    public function setPageMeta($pageMeta)
    {
        $this->Meta = $pageMeta;
        $this->Request->Parameter = new joy_data_Dictionary($this->Meta->PageArguments);
    }
    
    protected function loadAttributes()
    {
        $this->Logger->Debug("Controller::Attributes", __FILE__, __LINE__);

        joy_web_Attribute::Loader(&$this);
    }

    protected function createRender()
    {
        $this->View =& $this->RenderFactory->Builder($this->Meta->OutputMode);
        $this->View->setMeta($this->Meta);
    }

    protected function invokeMethod()
    {
        $this->Logger->Debug("Controller::InvokeMethod (".$this->Action.")", __FILE__, __LINE__);
       
        $class = new ReflectionClass($this);

        return $class->getMethod($this->Meta->Action)->invoke($this, $this->Meta->ActionArguments);
    }

    protected function render()
    {
        $this->PageOutput = $this->View->render();
    }

    protected function disposal()
    {
        $this->Event->Dispatch("Disposal");
    }

    public function display($action="", $arguments=array())
    {
        echo($this->call($action, $arguments));
    }

    public function call($action="", $arguments=array())
    {
        if ($action) {
            $this->Meta->Action = $action;
            $this->Meta->ActionArguments = $arguments;
        }

        $this->loadAttributes();

        $this->createRender(); 

        $activity = $this->invokeMethod();
        
        if (is_null($activity) == false) {
            $this->Workflow->Process($activity);
        }

        $this->render();

        $this->disposal();

        return $this->PageOutput;
    }
}

?>
