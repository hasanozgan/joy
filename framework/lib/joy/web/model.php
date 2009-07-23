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

class joy_web_Model extends joy_Object
{
    public $ormap;

    public function __construct()
    {
        parent::__construct();

        $namespace = $this->Config->Get("joy.plugins.ormap");
        $this->ormap = using($namespace);
    }

    public function __get($model)
    {
        return $this->ormap->GetTable($model);    
    }

}

?>
