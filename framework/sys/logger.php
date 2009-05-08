<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


class joy_Logger
{
    private $log_data = array();
    private static $instance;

    /* Log Levels */
    const ALL = -1;
    const NONE = 0;
    const DEBUG = 2;
    const WARNING = 4;
    const ERROR = 8;
    const FATAL = 16;

    static function &getInstance()
    {
        if (is_object($instance)) {
            $instance = new joy_Logger();
        }

        return $instance;
    }

    function add($level, $description, $file, $line)
    {
        //TODO: Add to $log arra Add to $log array..
    }

    function debug($description, $file, $line)
    {
        return $this->add(self::DEBUG, $description, $file, $line);
    }

    function warning($description, $file, $line)
    {
        return $this->add(self::WARNING, $description, $file, $line);
    }

    function error($description, $file, $line)
    {
        return $this->add(self::ERROR, $description, $file, $line);
    }

    function fatal($description, $file, $line)
    {
        return $this->add(self::FATAL, $description, $file, $line);
    }
}

?>
