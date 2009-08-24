<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.web.View");
import("joy.web.ui.renders.IRender");

class joy_web_ui_renders_Template extends joy_web_View implements joy_web_ui_renders_IRender
{
    protected $template;

    public function getEngine()
    {
        return $this->template;
    }

    protected function Init()
    {
        parent::Init();

        $namespace = $this->Config->Get("joy.plugins.template_engine");
        $this->template = using($namespace);
        $this->template->Assign("module", new joy_web_ui_ModuleLoader(&$this));
    }

    protected function getTemplateFile()
    {
        return $this->getViewFilePath();
    }

    public function Fetch()
    {
        // Assign all data
        $data = $this->getData();
        foreach ($data as $key=>$val) {
            $this->template->Assign($key, $val);
        }

        return $this->template->Fetch($this->getTemplateFile());
    }

    public function Display()
    {
        echo $this->Fetch();
    }

}

?>
