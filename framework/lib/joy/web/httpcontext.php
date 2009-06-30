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
import("joy.web");
import("joy.web.ui");

/* @TODO
 *   All Classes will Singleton Class
 */
class joy_web_HttpContext extends joy_Object
{
    public $View;
    public $Theme;
    public $Region;
    public $Translate;
    public $Request;
    public $Response;
    public $Session;
    public $Cookie;
    public $Server;
    public $Cache;
    public $User; //Default Anonymous

    public function __construct()
    {
        parent::__construct();

        $this->Region = new joy_web_Region($ip_address);
        $this->Translate = new joy_web_Translate(&$this->Region->Language);
        $this->Request = new joy_web_Request();
        $this->Response = new joy_web_Response();
        $this->Session = new joy_web_Session();
        $this->Cookie = new joy_web_Cookie();
        $this->Cache = new joy_web_Cache();

        $this->View = new joy_web_ui_View();
        $this->Theme = new joy_web_ui_Theme();
        $this->View->SetTheme($this->Theme);
        $this->View->SetTranslate($this->Translate);
    }
}

?>
