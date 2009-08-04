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
import("joy.region");

class joy_web_Region extends joy_Object
{
    public $Country;
    public $City;
    public $Language;
    public $Currency;
    public $Charset;
    public $DateFormat;
    public $TimeFormat;
    public $NumberFormat;
    public $MoneyFormat;

    /* 
     * TODO: Singleton class. 
     *       All Parameter Default Location and Override Cookie and Override Profile
     */

    public function __construct()
    {
        parent::__construct();

        $location = $this->getLocation();
        $this->Country = new joy_region_Country($location["country_code"]);
        $this->City = new joy_region_City($location["region_code"]);
        $this->Language = new joy_region_Language($this->Country); 
        $this->Currency = new joy_region_Currency($this->Country);
        $this->Charset = new joy_region_Charset($this->Country);
        $this->DateFormat = new joy_region_DateFormat($this->Country);
        $this->TimeFormat = new joy_region_TimeFormat($this->Country);
        $this->NumberFormat = new joy_region_NumberFormat($this->Country);
        $this->MoneyFormat = new joy_region_MoneyFormat($this->Country);
    }

    private function getLocation()
    {
        // @TODO 
        // Find IP to Location
        // Look Config
        // joy_web_Server::getInstance()->IPAddress;
    }
}

?>
