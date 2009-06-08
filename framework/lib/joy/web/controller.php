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

class joy_web_Controller extends joy_web_HttpContext
{
    protected $Action;
    protected $Parameters;
    protected $Models;

    public function SetPageMeta($pageMeta)
    {
        $this->Action = $pageMeta->Action;
        $this->ActionArguments = $pageMeta->ActionArguments;
        $this->Parameters = new joy_data_Dictionary($pageMeta->PageArguments);
        $this->Models = new joy_web_Model();

        $this->View->SetView($this->Action, $pageMeta->Page);
    }

    public function GetPageName()
    {
        return get_class($this);
    }

    public function GetActionName()
    {
        return $this->Action;
    }

    public function RunMethod()
    {
        $class = new ReflectionClass($this);
        $class->getMethod($this->Action)->invoke($this, $this->ActionArguments);
    }

    protected function RegisterEvents()
    {
        parent::RegisterEvents();

        $this->Event->Register("DBConnection", "OnConnection", $this);
    }
}

?>
