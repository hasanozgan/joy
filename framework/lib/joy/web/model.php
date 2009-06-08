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
    public function __get($model)
    {
        var_dump($model);

        $namespace = $this->Config->Get("joy.plugins.ormap");
        $ormap = using($namespace);
        return $ormap->GetTable($model);    
    }

}

?>
