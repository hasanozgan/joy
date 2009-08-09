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

class joy_web_httpcontext_Request extends joy_data_Dictionary
{
    public $Form;
    public $QueryString;
    public $Header;

    private static $instance;

    public static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function Init()
    {
        $this->list = new joy_data_Dictionary($_REQUEST);
        $this->Form = new joy_data_Dictionary($_POST);
        $this->QueryString = new joy_data_Dictionary($_GET);
        $this->Header = new joy_data_Dictionary(headers_list());

        $this->Event->Register("SafeRequest", "OnSafeRequest", $this);
    }

    public function OnSafeRequest(&$object, $args)
    {
        // TODO: MagicQuote & XSS & SqlInjection Check.
        $this->Logger->Debug("Safe Request", __FILE__, __LINE__);
    }
}

?>
