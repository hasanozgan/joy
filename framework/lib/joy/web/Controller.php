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
    public $Resource;

    public function Init()
    {
        parent::Init();

        $this->Model = joy_web_Model::getInstance();
        $this->Resource = joy_web_Resource::getInstance();
    }

    public function setPageMeta($pageMeta)
    {
        $this->Meta =& $pageMeta;
        $this->Request->Parameter = new joy_data_Dictionary($this->Meta->PageArguments);

        $this->View = joy_web_ui_RenderFactory::Builder($this->Meta->OutputMode);
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

    public function render()
    {
        $this->PageOutput = $this->View->render();

    }

    public function disposal()
    {
        $this->Event->Dispatch("Disposal");

        print($this->PageOutput);
    }

}

?>
