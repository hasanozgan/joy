<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.Object");
import("joy.web.ui.renders.IRender");

class joy_web_ui_renders_Layout extends joy_Object implements joy_web_ui_renders_IRender
{
    private $template;
    private $page;

    public function __construct($page)
    {
        parent::__construct();

        $namespace = $this->Config->Get("joy.plugins.template_engine");
        $this->template = using($namespace);
        $this->page =& $page;
    }
    
    public function Fetch()
    {
        // Layout file is exists
        if (!file_exists($this->page->GetLayoutFilePath())) {
            trigger_error("Layout File Not Found", E_USER_ERROR);
            return false;
        }

        // Assign all data
        foreach ($this->page->Data as $key=>$val) {
            $this->template->Assign($key, $val);
        }

        // Render Action Output
        $action_output = $this->template->Fetch($this->page->GetViewFilePath());
        $this->page->Data["page"]["PlaceHolder"] = $action_output;

        $this->template->Assign("page", $this->page->Data["page"]);

        // Assign all data
        foreach ($this->page->Data as $key=>$val) {
            $this->template->Assign($key, $val);
        }

        return $this->template->Fetch($this->page->GetLayoutFilePath());
    }

    public function Display()
    {
        echo $this->Fetch();
    }
}

?>