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

class joy_web_ui_renders_View extends joy_web_View implements joy_web_ui_renders_IRender
{
    public function __construct($page)
    {
        parent::__construct();

        $namespace = $this->Config->Get("joy.plugins.template_engine");
        $this->template = using($namespace);
        $this->page =& $page;
    }
 
    public function Fetch()
    {
        // Assign all data
        foreach ($this->page->Data as $key=>$val) {
            $this->template->Assign($key, $val);
        }

        return $this->template->Fetch($this->page->GetViewFilePath());
    }

    public function Display()
    {
        echo $this->Fetch();
    }

}

?>
