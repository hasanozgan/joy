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
    public $Page;
    protected $Values;

    abstract function Execute();

    public function __construct($values)
    {
        parent::__construct();
        $this->Values = (array)$values;
    }

    public function Run(&$page)
    {
        $this->Page =& $page;

        if (method_exists($this, "Execute")) {
            joy_system_Logger::getInstance()->Debug("Execute Attribute (".get_class($this)."::Run)",
                                         __FILE__, __LINE__);

            $this->Execute();
        }
    }

    public static function Loader(&$pageObject)
    {
        $namespace = joy_Configure::getInstance()->Get("joy.plugins.annotation");
        $annotation_helper = using($namespace);

        // Run Page Attributes
        $attributes = $annotation_helper->GetPageAttributes($pageObject->Meta->Page);
        foreach($attributes as $attribute) {
            if ($attribute instanceof joy_web_Attribute) 
                $attribute->Run(&$pageObject);
        }

        // Run Action Attributes
        $attributes = $annotation_helper->GetActionAttributes($pageObject->Meta->Page, $pageObject->Meta->Action);
        foreach($attributes as $attribute) {
            if ($attribute instanceof joy_web_Attribute) 
                $attribute->Run(&$pageObject);
        }
    } 
}
 
?>
