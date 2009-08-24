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

        $this->Model = joy_web_Model::getInstance();
        $this->Resource = joy_web_Resource::getInstance();
        $this->Workflow = joy_web_Workflow::getInstance();
    }

    public function setPageMeta($pageMeta)
    {
        $this->Meta = $pageMeta;
        $this->Request->Parameter = new joy_data_Dictionary($this->Meta->PageArguments);

        $this->View = joy_web_ui_RenderFactory::Builder($this->Meta->OutputMode);
        $this->View->setViewFile($this->Meta->Action);
        $this->View->setViewFolder($this->Meta->Page);
        $this->View->setMeta($this->Meta);
    }
    
    protected function loadAttributes()
    {
        $this->Logger->Debug("Controller::Attributes", __FILE__, __LINE__);

        joy_web_Attribute::Loader(&$this);
    }

    protected function addResource()
    {
        //TODO: Locale File (for multi language) loader..

        if (in_array($this->Meta->OutputMode, array(joy_web_View::VIEW, joy_web_View::LAYOUT))) {
            if ($this->Meta->Source == "Browser") {
                if ($file = $this->View->getLayoutFileUri("css")) {
                    $this->Resource->AddStyle($file);
                }

                if ($file = $this->View->getLayoutFileUri("js")) {
                    $this->Resource->AddScript($file);
                }
            }

            if ($file = $this->View->getViewFileUri("css")) {
                $this->Resource->AddStyle($file);
            }

            if ($file = $this->View->getViewFileUri("js")) {
                $this->Resource->AddScript($file);
            }
        }

    }

    protected function invokeMethod()
    {
        $this->Logger->Debug("Controller::InvokeMethod (".$this->Action.")", __FILE__, __LINE__);
       
        $class = new ReflectionClass($this);

        return $class->getMethod($this->Meta->Action)
                            ->invoke($this, $this->Meta->ActionArguments);
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

        $this->addResource();

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
