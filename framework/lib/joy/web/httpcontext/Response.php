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

class joy_web_httpcontext_Response extends joy_Object
{
    private $headers;
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
        $this->Event->Register("Header", "OnHeader", $this);
        $this->headers = array();
    }

    public function OnHeader(&$object, $args)
    {
        if (!empty($this->headers)) {
            foreach ($this->headers as $item) {
                header($item);
            }
        }

        $this->Logger->Debug("Response Header (OnHeader)", __FILE__, __LINE__);
    }

    public function SetHeader($item)
    {
        $this->headers[] = $item;
    }

    public function Redirect($url)
    {
        header("Location: $url");
        die();
    }
}

?>
