<?php

import("system.Object");

class system_web_context_Response extends system_Object
{
    private $_javascript_files;
    private $_stylesheet_files;
    private $_page_resources;

    private static $_instance;

    public static function &Instance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function Init()
    {
        $this->_javascript_files = array();
        $this->_stylesheet_files = array();
    }

    public function addResource($type, $key, $value) 
    {
        $this->_page_resources[$type][$key] = $value;
    }

    public function getResource($type, $key="") 
    {
        return empty($key) ? $this->_page_resources[$type]
                           : $this->_page_resources[$type][$key];

    }

    public function declareStylesheets()
    {
        $output = "";
        $site_root = trim(system_Configuration::Instance()->app["site_root"], '/');
        
        foreach ($this->_stylesheet_files as $css) {
            $prefix = "";
            if (strpos($css, "http://") === false && strpos($css, "https://") === false) {
                $prefix = sprintf("/%s", trim($site_root, "/"));
                $css = sprintf("/%s", trim($css, "/"));
            }

            if (!empty($prefix) && ($prefix != "/")) {
                $output .= sprintf("<link href='%s/%s' type='text/css' rel='stylesheet'>\n", $prefix, $css);
            }
            else {
                $output .= sprintf("<link href='%s' type='text/css' rel='stylesheet'>\n", $css);
            }
        }

        return $output;
    }


    public function declareJavascripts()
    {
        $output = "";
        $site_root = trim(system_Configuration::Instance()->app["site_root"], '/');

        foreach ($this->_javascript_files as $js) {
            $prefix = "";
            if (strpos($js, "http://") === false && strpos($js, "https://") === false) {
                $prefix = sprintf("/%s", trim($site_root, "/"));
                $js = sprintf("/%s", trim($js, "/"));
            }

            if (!empty($prefix) && ($prefix != "/")) {
                $output .= sprintf("<script type='text/javascript' src='%s/%s'></script>\n", $prefix, $js);
            }
            else {
                $output .= sprintf("<script type='text/javascript' src='%s'></script>\n", $js);
            }

        }

        return $output;
    }

    public function addJavascript($file) 
    {
        if (empty($file)) return;

        if (is_array($file)) {
            foreach ($file as $f) {
                $this->_javascript_files[$f] = $f;
            }
        }
        else {
            $this->_javascript_files[$file] = $file;
        }
    }

    public function addStylesheet($file) 
    {
        if (empty($file)) return;

        if (is_array($file)) {
            foreach ($file as $f) {
                $this->_stylesheet_files[$f] = $f;
            }
        }
        else {
            $this->_stylesheet_files[$file] = $file;
        }
    }
}

?>
