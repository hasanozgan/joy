<?php

import("system.Object");
import("system.module.Factory");

class system_web_context_Router extends system_Object
{
    public $Items;

    private static $_instance;
    private $_renderTypes = array("js", "css");

    public static function &Instance()
    {
        if (!is_object(self::$_instance)) {
            $config = using("system.Configuration");
            self::$_instance = new self();
            self::$_instance->load($config->router);
        }

        return self::$_instance;
    }

    public function createPage($uri)
    {
        $request = $this->find($uri);
        $canvas = using("system.module.Canvas", $request->module);

        if ($request->kind == RequestType::WIDGET) {
            $meta = $canvas->getWidget($request->action);
        }
        else {
            $meta = $canvas->getAction($request->action);
        }

        if ($meta) {
            var_dump($meta);
            return using($meta->page, $request);
        }
    }

    public function load($arr) 
    {
        foreach ($arr as $key=>$item) {
            $rules = array();
            $variables = array();

            $atoms = split(DIRECTORY_SEPARATOR, trim($item["url"], DIRECTORY_SEPARATOR));
            foreach($atoms as $atom) {
                list($rules[], $variables[]) = split(":", $atom);
                
                $this->Items[$key] = array("filter"=>sprintf("^\\/%s\\/", implode("\\/", $rules)),
                                       "module"=>$item["module"],
                                       "action"=>$item["action"],
                                       "variables"=>$variables);
            }
        }
    }

    public function makeLink($name, $params)
    {
        //TODO: Link Builder
    }

    public function find($request_uri)
    {
        list($request_uri) = split("\&", $request_uri);
        list($request_uri) = split("\?", $request_uri);

        $uri = "";
        $atoms = split("/", $request_uri);
        foreach ($atoms as $atom) {
           if (empty($atom)) continue;
           $uri .= "/$atom";
        }

        $site_root = trim($this->Config->app["site_root"], DIRECTORY_SEPARATOR);
        if (!empty($site_root)) {
            $uri = sprintf("/%s/", str_replace($site_root, "", trim($uri, DIRECTORY_SEPARATOR)));
        }
        else {
            $uri = sprintf("/%s/", trim($uri, DIRECTORY_SEPARATOR));
        }
 
        foreach ($this->Items as $key=>$item) {
            if (eregi($item["filter"], $uri)) {
                preg_match("/^{$item["filter"]}/U", $uri, $matches);
                $matched_uri = str_replace($matches[0], "", $uri);
                array_shift($matches);
                
                if ($matched_uri != "") {
                    $action_arguments = split("/", trim($matched_uri, DIRECTORY_SEPARATOR));
                }

                for ($i=0; $i < count($matches); $i++) {
                    $variable = $item["variables"][$i]; 

                    switch ($variable) {
                        case "module":
                            $item["module"] = trim($matches[$i], "/");
                            break;
                        case "action":
                            $item["action"] = trim($matches[$i], "/");
                            break;
                        default:
                            $item["parameters"][$variable] = $matches[$i];
                    }
                }
                
                unset($item["filter"]);
                unset($item["variables"]);

                $action_info = split("\.", $item["action"]);
                $item["action"] = array_shift($action_info);
                $action_extension = implode(".", $action_info);
   
                if (preg_match("/^view.*/", $action_extension, $matches, PREG_OFFSET_CAPTURE)) {
                    $item["kind"] = RequestType::WIDGET;
                    $item["arguments"] = array_merge((array)$item["parameters"], $_REQUEST);

                    array_shift($action_info); // update action_path
                    $action_extension = implode(".", $action_info);
                }
                else {
                    $item["kind"] = RequestType::ACTION;
                    $item["arguments"] = array_merge(array_values((array)$item["parameters"]), (array)$action_arguments);

                    if (preg_match("/^action.*/", $action_extension, $matches, PREG_OFFSET_CAPTURE)) {
                        array_shift($action_info); // update action_path
                        $action_extension = implode(".", $action_info);
                    }
                }

                $item["extension"] =  ($action_extension) ? $action_extension : "html";
                

                $render_type_rules = sprintf("/.*[%s]$/", implode("|", $this->_renderTypes));
                $item["content"] = preg_match($render_type_rules, $action_extension, $matches, PREG_OFFSET_CAPTURE) ? "resource" : "template";

                if ($item["content"] == "resource") {
                    $action_info = array_reverse($action_info);

                    if (count($action_info) > 1) {
                        $item["language"] = $action_info[1];
                    }

                    $item["content_type"] = array_shift($action_info);
                }

                $item["method"] = $_SERVER["REQUEST_METHOD"];
                
                $request = (object) $item; 
                $module = system_module_Factory::Load($request->module);
       
                if ($module) { break; }              
            }
            else {
                $module = null;
            }
        }

        return $request;
    }
}

class RequestType
{
    const ACTION = "action",
          WIDGET = "widget";
}

?>
