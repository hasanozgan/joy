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

    public function SetPageObject($pageObject)
    {
        $this->Action = $pageObject->Action;
        $this->Parameters = new joy_data_Dictionary($pageObject->PageArguments);
        $this->Models = new joy_web_Model();

        $this->View->SetView($this->Action, $pageObject->Page);
    }
}

?>
