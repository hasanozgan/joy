<?php

import("system.Object");

class system_web_context_Request extends system_Object
{
    private $_info;
    private static $_instance;

    public static function &Instance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function setInfo($key, $data=array())
    {
        if (is_object($key)) {
            $this->_info = $key;
        }
        else if ($key) {
            $this->_info->${key} = $data;
        }
    }

    public function getInfo()
    {
        return $this->_info;
    }


    public function Init()
    {
    }
}

?>
