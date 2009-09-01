<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.Object");

class joy_web_Receipt extends joy_Object
{
    static function GetPages()
    {
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
        $cache = joy_Cache::getInstance();
        $config = joy_Configure::getInstance();
        $settings_path = $config->get("app.folders.path.settings");

        $rules_file = $settings_path."router.ini";
        $key = md5($rules_file);

        $app_rules = (array)$cache->Local->Get("rules_$key");

        if ($app_rules[$key]["time"] != filectime($rules_file))
        {
            $pages = self::GetPages();

            // Set Rules
            $app_rules[$key]["rules"] = array();
            foreach ($pages as $class=>$file) 
            {
                $rule = array();
                $rule["alias"] = "^/{$class}/";
                $rule["class"] = $class;
                $rule["file"] = $file;

                array_push($app_rules[$key]["rules"], $rule);
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

                array_push($app_rules[$key]["rules"], $rule);
            }

            $cache->Local->Set("rules_$key", $app_rules, 3600);

        }

        return $app_rules[$key]["rules"];
    }


    static function FromURI($uri)
    {
        $uri = sprintf("/%s", ltrim($uri, "/"));
        $rules = self::GetRules();

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
            $extensions = split("\.", $method);
            $action_name = array_shift($extensions);
            $extensions = array_reverse($extensions);
            $mode = array_shift($extensions);
            $extensions =array_reverse($extensions);
            $modeParams = implode(".", $extensions);

            $page->SiteRoot = str_replace("/index.php", "", $_SERVER["PHP_SELF"]);
            $page->Page = $class_name;
            $page->PageArguments = $page_args;
            $page->PagePath = $class_path;
            $page->Action = $action_name;
            $page->ActionArguments = $method_arguments;
            $page->Uri = sprintf("%s/%s", $page->Page, $page->Action);
            $page->PageUri = sprintf("%s/%s", $page->SiteRoot, $page->Uri);
            $page->OutputMode = joy_web_ui_RenderFactory::GetOutputMode($mode);
            $page->OutputModeArguments = (empty($modeParams) ? null : $modeParams);
            $page->Source = "Browser";
        }

        return $page;
    }


}
