<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// TODO: Add to config this parameters
define("FILE_EXTENSION_LIST", "class.php:interface.php");
define("CLASS_PATH", APPLICATION_ROOT."/control/library;".FRAMEWORK_ROOT."/library");

class system_Namespace
{
    public $folder;
    public $file;
    public $class;

    public function __construct($_file, $_folder, $_class)
    {
        $this->file = $_file;
        $this->folder = $_folder;
        $this->class = $_class;
    }

    public function instance($args)
    {
        $class = new ReflectionClass($this->class);
        return $class->newInstanceArgs($args);
    }

    public static function Importer($namespace, $classpath="", $extensions="")
    {
        if ($classpath == "") {
            $classpath = CLASS_PATH;
        }

        if ($extensions == "") {
            $extensions = FILE_EXTENSION_LIST;
        }

        $classpath = split(";", $classpath);
        $extensions = split(":", $extensions);
        
        $namespace_path = str_replace(".", DIRECTORY_SEPARATOR, $namespace);
        foreach ($classpath as $lib_root) 
        {
            $lib_root = rtrim($lib_root, DIRECTORY_SEPARATOR);
            $path = $lib_root.DIRECTORY_SEPARATOR.$namespace_path;

            foreach ($extensions as $ext) {
                $path = $lib_root.DIRECTORY_SEPARATOR.$namespace_path.'.'.$ext;

                if (file_exists($path)) {
                    //require class
                    require_once($path);
                    
                    // find class
                    $content = file_get_contents($path, true);
                    preg_match('/class\ +(.*)/', $content, $matches, PREG_OFFSET_CAPTURE);
                    $class = trim(array_shift(explode(" ", $matches[1][0])));

                    //find file
                    $file = array_pop(split(DIRECTORY_SEPARATOR, $path));
                    
                    return (new system_Namespace($file, dirname($path), $class));
                }
            }
        }

        throw new Exception("Namespace ($namespace) Not Found");
    }
}

function import($namespace)
{
    if (empty($namespace)) {
        throw new Exception("namespace not found");
    }

    return system_Namespace::Importer($namespace);
}

function using($namespace) 
{
    if (empty($namespace)) {
        throw new Exception("namespace not found");
    }

    $ns = import($namespace);

    // Check namespace is folder or file
    if (!$ns->file) {
        throw new Exception("Please set file path");
    }

    $args = func_get_args();
    array_shift($args);
    if (method_exists($ns->class, "Instance")) {
        $class = new ReflectionClass($ns->class);
        $method = $class->getMethod("Instance");
        if ($class == $method->getDeclaringClass()) {
            return $method->invokeArgs($class, $args);
        }
    }

    return $ns->instance($args);
}


?>
