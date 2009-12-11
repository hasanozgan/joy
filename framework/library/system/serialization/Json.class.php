<?php

require_once("vendors/json/FastJSON.class.php");

class system_serialization_Json
{
    public static function Decode($param)
    {
        $json = new FastJSON();
        return $json->decode($param);
    }

    public static function Encode($param)
    {
        $json = new FastJSON();
        return $json->encode($param);
    }
}

?>
