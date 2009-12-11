<?php

define("CACHE_FARM", 0);
define("CACHE_MACHINE", 1);

class system_Cache
{
    private static $_instance;

    public static function &Instance($type=CACHE_FARM)
    {
        if (!is_object(self::$_instance[$type])) {
            self::$_instance[$type] = new self();
        }

        return self::$_instance[$type];
    }
}

?>
