<?php

import("system.Object");

class system_web_context_Module extends system_Object
{
    private static $_instance;

    public static function &Instance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}

?>
