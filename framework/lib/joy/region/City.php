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

class joy_region_City extends joy_Object
{
    public $Name;
    public $RegionCode;
    public $WeatherCode;
    public $ZipCode;
    public $AreaCode;
    public $TimeZone;
    public $Latitude;
    public $Longtitude;

    /*
     * @param $country_code must be ISO 3166-2 (tr, us, gb, jp etc..) 
     * See => http://en.wikipedia.org/wiki/ISO_3166-2
     */
    public function __construct($country_code)
    {
        parent::__construct();
         
    }
}

?>
