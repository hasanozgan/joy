<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


define("RULES_SHM_SIZE", 1024*10);
define("RULES_SHM_KEY", ftok(__FILE__, "R"));

define("PAGES_SHM_SIZE", 1024*50);
define("PAGES_SHM_KEY", ftok(__FILE__, "P"));

import("joy.Object");

class joy_web_PageFactory extends joy_Object
{
    static function Builder()
    {
        $pageMeta = self::PreparePageMeta();

        return self::Loader($pageMeta);
    }

    static function CreatePage($pageMeta)
    {
        require_once($pageMeta->PagePath);
        $class = new ReflectionClass($pageMeta->Page);
      
        if (!$class->hasMethod($pageMeta->Action) || !$class->getMethod($pageMeta->Action)->isPublic()) {
            throw new Exception("Action($pageMeta->Action) Not Found");
        }

        // Page Instance 
        $page = $class->newInstance();
        $page->SetPageMeta($pageMeta);

        //  Dispatch Page Events...
        $page->DispatchEvents();

        return $page;
    }

    static function Loader($pageMeta)
    {
        $page =& self::CreatePage($pageMeta);

        $page->LoadAttributes(); 

        $page->RunMethod();

        $page->Render();

        $page->Complete();
    }

    static function GetPages()
    {
        //TODO: Use Shared Memory...
        $config = joy_Configure::getInstance();
        $page_path = $config->get("app.folders.path.page");

        if (is_dir($page_path) && ($dh = opendir($page_path))) 
        {
            while (($file = readdir($dh)) !== false) 
            {
                if ($file == "." || $file == "..") continue;

                list($filename, $ext) = explode(".",$file);
                if (in_array($ext, array(CLASS_EXTENSION))) {
                    $file = sprintf("%s%s%s", rtrim($page_path, DIRECTORY_SEPARATOR), 
                                    DIRECTORY_SEPARATOR, 
                                    ltrim($file, DIRECTORY_SEPARATOR));

                    // find class
                    $content = file_get_contents($file, true);
                    preg_match('/class\ +(.*)/', $content, $matches, PREG_OFFSET_CAPTURE);
                    $class = trim(array_shift(explode(" ", $matches[1][0])));

                    if ($class) {
                        $pages[$class] = $file;
                    }
                }
            }
        }

        return (array) $pages;
    }

    static function GetRules()
    {
        //TODO: Use Shared Memory

        $config = joy_Configure::getInstance();
        $settings_path = $config->get("app.folders.path.settings");

        $rules_file = $settings_path."router.ini";

        // Load Router.ini
        // DIKKAT: Pages & Rules & Config tanımları shared memory'e eklenirken app_id'ye gore eklenmeli.
        // Yoksa aynı anda 2 proje çalıştığında çok başımız ağrır.
        
        $shm_id = shmop_open(RULES_SHM_KEY, "c", 0644, RULES_SHM_SIZE);

        if ($shm_id) {
            $app_rules = (array)unserialize(shmop_read($shm_id, 0, RULES_SHM_SIZE));
        }
        else {
            joy_system_Logger::getInstance()->error("Cache dont usage in Router.Ini Loading time", __FILE__, __LINE__);
        }

        if ($app_rules[$rules_file]["time"] != filectime($rules_file))
        {
            $pages = self::GetPages();

            // Set Rules
            $app_rules[$rules_file]["rules"] = array();
            foreach ($pages as $class=>$file) 
            {
                $rule = array();
                $rule["alias"] = "^/{$class}/";
                $rule["class"] = $class;
                $rule["file"] = $file;

                array_push($app_rules[$rules_file]["rules"], $rule);
            }

            $aliases = parse_ini_file($settings_path."router.ini", true);
            foreach($aliases as $alias => $params) 
            {
                $rule = array();
                if (array_key_exists($params["page"], $pages) == false) {
                    throw new Exception("Page ({$params["page"]}) Not Found In Router.ini"); 
                }

                $rule["alias"] = $alias;
                $rule["class"] = $params["page"];
                $rule["file"] = $pages[$params["page"]];

                if (isset($params["action"])) {
                    $rule["method"] = $params["action"];
                }
                if (isset($params["parameters"])) {
                    $rule["request"] = (array)trim($params["parameters"], ",");
                }

                array_push($app_rules[$rules_file]["rules"], $rule);
            }

            // Write to Shared Memory
            if ($shm_id) {
                shmop_write($shm_id, serialize($app_rules), 0);
            }
        }

        // Close shared memory handler
        if ($shm_id) {
            shmop_close($shm_id);
        }

        return $app_rules[$rules_file]["rules"];
 
    }

    static function PrepareUri()
    {
        $site_root = str_replace("/index.php", "", $_SERVER["PHP_SELF"]);
        $path = str_replace($site_root, "", $_SERVER["REQUEST_URI"]);
        $path = str_replace("?{$_SERVER["QUERY_STRING"]}", "", $path);

        return rtrim($path, "/")."/";
    }

    static function PreparePageMeta()
    {
        $rules = self::GetRules();
        $uri = self::PrepareUri();

        $config = joy_Configure::getInstance();
 
        // Set Home Page
        if ("/" == trim($uri)) $uri .= $config->get("app.home_page")."/";
        
        // Find Page 
        foreach ($rules as $r) 
        {
            $filter = str_replace("{*}", "(.*)", $r["alias"]);
            $filter = str_replace("{0-9}", "[0-9]", $filter);

            $filter = str_replace("/", "\/", $filter);

            if (eregi($filter, $uri)) {
                preg_match("/^$filter/U", $uri, $matches);
                $uri =str_replace($matches[0], "", $uri);
                array_shift($matches);

                $page_args = array();
                for ($i=0; $i < count($matches); $i++) 
                {
                    $param = $r["request"][$i];

                    if (empty($param)) { $param = "param_$i"; }
                    $page_args[$param] = $matches[$i];
                }

                $class_name = $r["class"];
                $config = joy_Configure::getInstance();
                $class_path = $r["file"];

	            $items = trim($uri, "/");
                $items = (empty($items) ? array() : split("/", $items));

                if ($r["method"]) {
                    $method = $r["method"];
                }
                else if (!($method = array_shift($items))) {
                    $method = "index";
                }

		        $method_arguments = $items;
                break;
            }
        }

        if ($class_name) {
            $page = new stdClass();
            list($action_name, $type) = split("\.", $method);

            $page->Page = $class_name;
            $page->PageArguments = $page_args;
            $page->PagePath = $class_path;
            $page->Action = $action_name;
            $page->RenderType = strtolower($type);
            $page->ActionArguments = $method_arguments;
        }

        return $page;
    }

    static function FindPage($rules, $uri)
    {
        // Set Home Page
        if ("/" == trim($uri)) $uri .= home_page."/";

        // Match 
        foreach ($rules as $r) 
        {
            $filter = str_replace("{*}", "(.*)", $r["alias"]);
            $filter = str_replace("/", "\/", $filter);

            if (eregi($filter, $uri)) {
                preg_match("/^$filter/U", $uri, $matches);
                $uri =str_replace($matches[0], "", $uri);
                array_shift($matches);

                $page_args = array();
                for ($i=0; $i < count($matches); $i++) 
                {
                    $param = $r["request"][$i];

                    if (empty($param)) { $param = "param_$i"; }
                    $page_args[$param] = $matches[$i];
                }

                $class_name = $r["class"];
                $class_path = controller_root."/".$r["file"];

	            $items = trim($uri, "/");
                $items = split("/", $items);

                if ($r["method"]) {
                    $method = $r["method"];
                }
                else if (count($items) && !($method = array_shift($items))) {
                    $method = "index";
                }

		        $method_arguments = $items;
                break;
            }
        }

		if (!file_exists($class_path)) {
			die("Page Not Found");
		}
		else {
			require_once($class_path);
		}

		if(!method_exists($class_name, $method)) {
			die("Action Not Found");
		} 
		else {
			self::set_module_name($class_name);
			self::set_action_name($method);

			eval("\$class = new $class_name();");

            $class->page_parameters = (array)$page_args;

            $reflection = new ReflectionAnnotatedClass($class);
            $r = $reflection->getMethod($method);


            // Attribute Page'e parametre olarak aldığı sınıfın instanceof ile kontrol eder. 
            // Ornegin View Interface'inden implement edilmis ise View Layout bilgilerini alir gibi.

            $attributes = $r->getAnnotations();
            foreach ($attributes as $attr) {
                $attr->Run(&$class);
            }

            $output = array();
            $method_arguments = array($method_arguments, &$output);
			call_user_method_array($method, $class, $method_arguments);

// TODO:
//           if ($class instanceof IView) {
//               $class->view->items = array_merge($output, $class->view->items);
//           }

//            if ($class->is_serialize) {
//                $class->serialize();
//            }
//            else {
//                $class->render();
//            }
//            var_dump($output);
		}
    }
}

?>
