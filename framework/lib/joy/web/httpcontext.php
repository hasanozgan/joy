<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.Object");
using("joy.web");
using("joy.web.ui");


class joy_web_HttpContext extends joy_Object
{
    public $View;
    public $Theme;
    public $Language;
    public $Text;
    public $Request;
    public $Response;
    public $Session;
    public $Cookie;
    public $Cache;

    public function __construct()
    {
        parent::__construct();

        $this->Text = new joy_web_ui_Text($this->Language);
        $this->Request = new joy_web_Request();
        $this->Response = new joy_web_Response();
        $this->Session = new joy_web_Session();
        $this->Cookie = new joy_web_Cookie();
        $this->Cache = new joy_web_Cache();

        $this->View = new joy_web_ui_View();
        $this->Theme = new joy_web_ui_Theme();
        $this->Language = new joy_web_Language();
        $this->View->SetTheme($this->Theme);
        $this->View->SetText($this->Text);
    }

}

?>
