<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("system.Object");

class system_web_context_Model extends system_Object
{
    public $ormap;

    private static $instance;

    public static function &Instance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        parent::__construct();

        $namespace = $this->Config->framework["drivers"]["ormap"];
        $this->ormap = using($namespace);

        try {
            $dsn = $this->Config->app["servers"]["database"]["dsn"];
            $this->ormap->Connection($dsn);
            $this->ormap->LoadModels();
        }
        catch (Exception $ex) {
            die("Database connection failure. Check your data source name (DSN) in application config file");
        }
    }

    public function __get($model)
    {
#       try {
            return $this->ormap->GetTable($model);    
#       }
#        catch (Exception $ex) {
#            $this->ormap->LoadModels();
            echo $model;
#           return $this->ormap->GetTable($model);    
#       }
    }

    public function GenerateModels()
    {
        $this->ormap->GenerateModels();

    }
}

?>
