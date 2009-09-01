<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.system");

class joy_Object
{
    public $Config;
    public $Logger;
    public $Event;
    public $Cache;

    public function __construct()
    {
        //$key = md5(APP_ROOT);
        $this->Cache =& joy_Cache::getInstance();
        $this->Config =& joy_Configure::getInstance();
        $this->Logger =& joy_system_Logger::getInstance();
        $this->Event =& joy_system_Event::getInstance();

        $this->RegisterEvents();
        $this->Init();
    }

    protected function Init()
    {
        // Inheritance
    }

    protected function RegisterEvents()
    {
        // Inheritance
    }

    private function importClass($namespace)
    {
        $obj = import($namespace);

        // Check namespace is folder or file
        if (!$obj->file) {
            throw new Exception("Please set file path");
        }

        return $obj;
    }

    public function instance($class_with_namespace)
    {
        $args = func_get_args(); array_shift($args);

        $obj = $this->importClass($class_with_namespace);
        return $obj->instance($args);
    }

    public function instance_of($class_with_namespace)
    {
        $obj = $this->importClass($class_with_namespace);

        return is_a($this, $obj->class); // instanceof operator only works classType not work string
    }
}

?>
