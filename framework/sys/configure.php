<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class joy_Configure 
{
    private $values;
    private static $instance;
  
    static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new joy_Configure();
        }

        return self::$instance;
    }

    public function set($key, $value)
    {
        $offset = substr($key, strrpos($key, ".")+1);
        $segment = substr($key, 0, (strlen($offset)+1) * -1);

        return $this->values["settings"][$segment][$offset] = $value;
    }

    public function getSection($section)
    {
        return $this->values["settings"][$section];
    }

    public function get($key)
    {
        $offset = substr($key, strrpos($key, ".")+1);
        $segment = substr($key, 0, (strlen($offset)+1) * -1);

        return $this->values["settings"][$segment][$offset];
    }

    public function &getAll()
    {
        return $this->values["settings"];
    }

    private function prepare()
    {
        $root = $this->get("joy.root");

        $joy_folders = $this->getSection("joy.folders");
        foreach($joy_folders as $key=>$value)
        {
            $this->set("joy.folders.path.$key", $this->fix_path($root, $value));
        }

        $app_root = $this->get("app.root");

        $app_folders = $this->getSection("app.folders");
        foreach($app_folders as $key=>$value)
        {
            $this->set("app.folders.path.$key", $this->fix_path($app_root, $value));
        }

        $site_root = $this->get("app.site_root");
        $this->set("app.site_root", $this->fix_path($site_root));

        $doc_root = $this->get("app.folders.path.document_root");

        $doc_folders = $this->getSection("app.document_root.folders");
        foreach($doc_folders as $key=>$value)
        {
            $this->set("app.document_root.folders.path.$key", $this->fix_path($doc_root, $value));
            $this->set("app.document_root.folders.uri.$key", $this->fix_path($site_root,$value));
        }
    }

    public function load($config_file)
    {
        $success = false;

        if (file_exists($config_file))
        {
            $ini_file = parse_ini_file($config_file, true);
            $this->values["settings"] = array_merge((array)$this->values["settings"], $ini_file);
            $this->values["files"][$config_file]["time"] = filectime($config_file);

            if (($configuration = $this->get("joy.configuration")) && file_exists("$config_file.$configuration")) {
                $ini_file = parse_ini_file("$config_file.$configuration", true);
                $this->values["settings"] = array_merge((array)$this->values["settings"], $ini_file);
                $this->values["files"][$config_file]["time"] = filectime($config_file);
            }
                
            $this->prepare();

            $success = true;
        }
        
        return $success;
    }

    private static function fix_path($path, $folder="")
    {
        // DIRECTORY_SEPERATOR usage for URI, it is bug. I know but Windows Sucks...
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        $folder = trim($folder, DIRECTORY_SEPARATOR);

        if (empty($folder)) {
            return sprintf("%s/", $path);
        }

        return sprintf("%s/%s/", $path, $folder);
    }


}

?>
