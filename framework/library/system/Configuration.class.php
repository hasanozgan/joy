<?php

import("system.configuration.Spyc");

class system_Configuration
{
    public $Items;

    private static $_instance;

    public static function &Instance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __get($namespace)
    {
        return $this->Items[$namespace];
    }

    public static function Load($namespace, $str)
    {
        $config =& system_Configuration::Instance(); 
        $config->Items[$namespace] = spyc_load($str);
    }

    public static function LoadFile($namespace, $file)
    {
        $config =& system_Configuration::Instance(); 
        $config->Items[$namespace] = spyc_load_file($file);
    }
}

?>
