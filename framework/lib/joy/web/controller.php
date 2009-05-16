<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.data.Dictionary");
using("joy.web.HttpContext");

class joy_web_Controller extends joy_web_HttpContext
{
    protected $Action;
    protected $Parameters;

    public function SetPageObject($pageObject)
    {
        $this->Action = $pageObject->Action;
        $this->Parameters = new joy_data_Dictionary($pageObject->PageArguments);

        $this->View->SetView($this->Action, $pageObject->Page);
    }
}

?>
