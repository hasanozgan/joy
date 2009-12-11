<?php

import("system.Object");
import("system.module.Handler");
import("system.module.Widget");

class system_module_Factory
{
    private static $modules;

    private static function CreateHandler($modulename)
    {
        $request->module_name = $modulename;
        $request->module_path = sprintf("%s/control/module/%s", APPLICATION_ROOT, $request->module_name);
        $request->module_file = sprintf("%s.class.php", $request->module_name);

        $class_path = sprintf("%s/%s", $request->module_path, $request->module_file);

        if (file_exists($class_path)) 
        {
            require_once($class_path);
            
            $content = file_get_contents($class_path, true);
            preg_match('/class\ +(.*)/', $content, $matches, PREG_OFFSET_CAPTURE);
            $classname = trim(array_shift(explode(" ", $matches[1][0])));

            if ($classname) {
                $request->module_class = $classname;
                $founded = true;
            }
        }

        return ($founded) 
                    ? new system_module_Handler($request)
                    : false;
    }

    public static function Load($name)
    {
        if (isset(self::$modules[$name]) == false) {
            self::$modules[$name] =& self::CreateHandler($name);
        }

        return self::$modules[$name];
    }
} 
