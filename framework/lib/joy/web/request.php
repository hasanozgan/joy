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

class joy_web_Request extends joy_Object
{
    public $Form;
    public $QueryString;

    public function __construct()
    {
        // TODO: MagicQuote & XSS & SqlInjection Check.

        $this->Form = new joy_data_Dictionary($_POST);
        $this->QueryString = new joy_data_Dictionary($_GET);


    }
}

?>
