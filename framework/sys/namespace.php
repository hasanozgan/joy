<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define("CLASS_EXTENSION", "php");

class joy_Namespace
{
    static $IsAddedLibraryPath;
    static $items;

    static function Items($key=null, $value=null)
    {
        if ($key == null) {
            return self::$items[APP_ROOT];
        }
        else if ($value == null) {
            return self::$items[APP_ROOT][$key];
        }
        
        self::$items[APP_ROOT][$key] = $value;

        return $value;
    }

    static function InsertTable($namespace)
    {
        $config = joy_Configure::getInstance();

        $lib_folders = array($config->get("joy.folders.path.library"),
                             $config->get("app.folders.path.library"));

        // Set Include Path For Library Paths
        if (self::$IsAddedLibraryPath == false) {

            $pathList = split(PATH_SEPARATOR, get_include_path());
            foreach($lib_folders as $item) {
                array_push($pathList, $item);
            }
            $pathList = array_unique($pathList);
            set_include_path(implode(PATH_SEPARATOR, $pathList));
            self::$IsAddedLibraryPath = true;
        }


        $namespace_path_name = str_replace(".", DIRECTORY_SEPARATOR, $namespace);
        foreach ($lib_folders as $lib_root) 
        {
            $lib_root = rtrim($lib_root, DIRECTORY_SEPARATOR);
            $path = $lib_root.DIRECTORY_SEPARATOR.$namespace_path_name;
            $file = $lib_root.DIRECTORY_SEPARATOR.$namespace_path_name.'.'.CLASS_EXTENSION;

            if (file_exists($file)) {
                return self::ImportClass($file);
            }
            else if (is_dir($path)) {
                if ($dh = opendir($path)) {
                    // Not support folder include...
                    while (($file = readdir($dh)) !== false) {
                        if ($file == "." || $file == "..") continue;

                        list($filename, $ext) = explode(".",$file);
                        if (in_array($ext, array(CLASS_EXTENSION))) {
                            $file = sprintf("%s%s%s", rtrim($path, DIRECTORY_SEPARATOR), 
                                            DIRECTORY_SEPARATOR, 
                                            ltrim($file, DIRECTORY_SEPARATOR));
                            self::ImportClass($file);
                        }
                    }
                    closedir($dh);
                }
                
                return (object) array("folder"=>$path);
            }
        }

        throw new Exception("Namespace ($namespace) Not Found");
    }

    public static function ImportClass($path)
    {
        require_once($path);
       
        if (self::Items($path)) return self::Items($path);

        //find folder
        $folder = realpath(dirname($path));

        // find class
        $content = file_get_contents($path, true);
        preg_match('/class\ +(.*)/', $content, $matches, PREG_OFFSET_CAPTURE);
        $class = trim(array_shift(explode(" ", $matches[1][0])));

        //find file
        $file = array_pop(split(DIRECTORY_SEPARATOR, $path));

        self::Items($path, ($obj = new joy_Namespace($file, $folder, $class)));

        return $obj;
    }


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
}

function import($namespace)
{
    return joy_Namespace::InsertTable($namespace);
}

function using($namespace) 
{
    $obj = import($namespace);

    // Check namespace is folder or file
    if (!$obj->file) {
        throw new Exception("Please set file path");
    }

    $args = func_get_args();
    array_shift($args);

    return $obj->instance($args);
}

/* Test Code  
#unset($_SESSION["__namespaces__"]);

using("joy");
$a = call("joy.Array", 1, 2);
echo  $a->va1;
var_dump(joy_Namespace::Items());
/* */
?>
