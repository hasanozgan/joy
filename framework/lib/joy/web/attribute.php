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

abstract class joy_web_Attribute extends joy_Object
{
    protected $page;

    abstract function Execute();

    public function __construct($method)
    {
        parent::__construct();
    }

    public function Run(&$page)
    {
        $this->page =& $page;
        if (method_exists($this, "Execute")) {
            $this->Execute();
        }
    }

    public static function Loader(&$pageObject)
    {
        $namespace = joy_Configure::getInstance()->Get("joy.plugins.annotation");
        $annotation_helper = using($namespace);
        $attributes = $annotation_helper->GetPageAttributes($pageObject->GetPageName());
        foreach($attributes as $attribute) {
            if ($attribute instanceof joy_web_Attribute) 
                $attribute->Run(&$_page);
        }

        $attributes = $annotation_helper->GetActionAttributes($pageObject->GetPageName(), $pageObject->GetActionName());
        foreach($attributes as $attribute) {
            if ($attribute instanceof joy_web_Attribute) 
                $attribute->Run(&$_page);
        }
    } 
}
 
?>
