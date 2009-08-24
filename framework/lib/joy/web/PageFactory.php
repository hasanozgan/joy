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
import("joy.web.ui.RenderFactory");

class joy_web_PageFactory extends joy_Object
{
    static function Builder()
    {
        $uri = self::RequestHandler();
        $receipt = joy_web_Receipt::FromURI($uri);
        $page =& self::Assembly($receipt);
        $page->display();
    }

    static function Assembly($receipt)
    {
        $page =& self::CreatePage($receipt);

        return $page;
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
        $page->setPageMeta($pageMeta);

        //  Dispatch Page Events...
        $page->DispatchEvents();

        return $page;
    }

    static function RequestHandler()
    {
        $site_root = str_replace("/index.php", "", $_SERVER["PHP_SELF"]);
        $path = str_replace($site_root, "", $_SERVER["REQUEST_URI"]);
        $path = str_replace("?{$_SERVER["QUERY_STRING"]}", "", $path);

        return rtrim($path, "/")."/";
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
