<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define("CONFIG_SHM_SIZE", 1024*100);
define("CONFIG_SHM_KEY", ftok(__FILE__, "A"));


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
        //FIXME: En son kaydedilen config ini hepsini ezer.
        $success = false;
        $shm_id = shmop_open(CONFIG_SHM_KEY, "c", 0644, CONFIG_SHM_SIZE);

        if ($shm_id) {
            $config_list = (array)unserialize(shmop_read($shm_id, 0, CONFIG_SHM_SIZE));
            $this->values = $config_list[APP_ROOT];
        }
        else {
            joy_Logger::getInstance()->error("Cache dont usafe in Config Loading time", __FILE__, __LINE__);
        }

        if (file_exists($config_file) && $this->values["files"][$config_file] != filectime($config_file))
        {
            $ini_file = parse_ini_file($config_file, true);
            $this->values["settings"] = array_merge((array)$this->values["settings"], $ini_file);
            $this->values["files"][$config_file] = filectime($config_file);
            $this->prepare();

            if ($shm_id) {
                $config_list[APP_ROOT] =  $this->values; 
                shmop_write($shm_id, serialize($config_list), 0);
            }

            $success = true;
        }
        
        if ($shm_id) {
            shmop_close($shm_id);
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
