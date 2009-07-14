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

    public function __construct($page)
    {
        parent::__construct();

        $namespace = $this->Config->Get("joy.plugins.template_engine");
        $this->template = using($namespace);
        $this->page =& $page;
    }
    
    public function Fetch()
    {
        var_dump($this->page->GetThemeName());
        var_dump($this->page->GetLayoutFileName());
        var_dump($this->page->GetViewFileName());  
        var_dump($this->page->GetViewFolderName());

    }

    public function Display()
    {

    }
}

?>
