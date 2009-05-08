<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.web.HttpContext");

class joy_web_Controller extends joy_web_HttpContext
{
    private $layout;        // joy_web_ITemplateEngine
    private $view;          // joy_web_ITemplateEngine
    protected $Models;      // joy_web_IModelEngine

    public function __construct()
    {
        $template_engine = joy_Configure::Get("joy.plugins.template_engine_class");
        $or_map = joy_Configure::Get("joy.plugins.or_map_class");
    }

    public function setView()
    {
    
    }

    public function setLayout()
    {
    
    }
}

?>
