<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//@TODO:
// 
// 1) Required file save method
// 2) 

class joy_system_Logger
{
    private $log_data = array();
    private static $instance;

    /* Log Levels */
    const NONE = 0;
    const DEBUG = 2;
    const INFO = 4;
    const WARNING = 8;
    const ERROR = 16;
    const FATAL = 32;
    const ALL = 256;

    static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new joy_system_Logger();
        }

        return self::$instance;
    }

    function statusToString($level)
    {
        switch ($level) 
        {
            case self::DEBUG: return "DEBUG";
            case self::INFO: return "INFO";
            case self::WARNING: return "WARNING";
            case self::ERROR: return "ERROR";
            case self::FATAL: return "FATAL";
        }

        return "N/A";
    }

    public function Add($level, $description, $file="N/A", $line="N/A")
    {
        $this->log_data[] = sprintf("[%s] [%s] [%s:%s] [%s]\n", 
                                    date("Y-m-d H:i:s"), 
                                    $this->statusToString($level), 
                                    $file, 
                                    $line, 
                                    $description);
    }

    public function Debug($description, $file="N/A", $line="N/A")
    {
        return $this->Add(self::DEBUG, $description, $file, $line);
    }

    function Info($description, $file="N/A", $line="N/A")
    {
        return $this->Add(self::INFO, $description, $file, $line);
    }

    function Warning($description, $file="N/A", $line="N/A")
    {
        return $this->Add(self::WARNING, $description, $file, $line);
    }

    function Error($description, $file="N/A", $line="N/A")
    {
        return $this->Add(self::ERROR, $description, $file, $line);
    }

    function Fatal($description, $file="N/A", $line="N/A")
    {
        return $this->Add(self::FATAL, $description, $file, $line);
    }

    function Fetch()
    {
        return implode("<br/>", $this->log_data);
    }

    function Output()
    {
        return sprintf("<hr/><center><strong>T R A C E &nbsp; L O G</strong></center><hr/><small>%s</small>",
                       $this->Fetch());
    }
}

?>
