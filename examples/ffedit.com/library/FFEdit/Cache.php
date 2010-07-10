<?php

class FFEdit_Cache
{
    protected static $_instance;
    protected $_cache;

    public static function getInstance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new FFEdit_Cache();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        $this->_cache = new Memcache();
        $this->_cache->addServer("localhost", 11211);
    }

    public function set($key, $value, $duration)
    {
        $this->_cache->set($key, $value, 0, $duration);
    }

    public function get($key)
    {
        return $this->_cache->get($key);
    }

}
