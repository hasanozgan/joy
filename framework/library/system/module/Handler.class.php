<?php

import("system.module.Canvas");
import("system.web.view.Layout");

class system_module_Handler
{
    private $info;
    private $module;
    private $module_reflection;
    private $canvas;

    public function __construct($request)
    {
        $this->info =& $request;
        $this->info->widgets = array();
        $this->module_reflection = new ReflectionClass($this->info->module_class);
        $this->module = $this->module_reflection->newInstance();
        $this->canvas = new system_module_Canvas($request->module_name);
    }

    public function hasAction($name)
    {
        $ref = new ReflectionClass($this->info->module_class);
        
        return (boolean) $ref->hasMethod($name);
    }

    public function hasWidget($name)
    {
        return (boolean) $this->getWidget($name);
    }

    protected function getWidget($name, $args=array())
    {
        if (!$this->info->widgets[$name]) {
            $widget_path = sprintf("%s/%s", $this->info->module_path, $name);
            $class_path = sprintf("%s/%s.class.php", $widget_path, $name);

            if (file_exists($class_path)) 
            {
                require_once($class_path);
                
                $content = file_get_contents($class_path, true);
                preg_match('/class\ +(.*)/', $content, $matches, PREG_OFFSET_CAPTURE);
                $classname = trim(array_shift(explode(" ", $matches[1][0])));

                if ($classname) {
                    $ref = new ReflectionClass($classname);
                    $this->info->widgets[$name] = $ref->newInstance($this->info->module_name, $name, $args);
                }
            }
        }
        else if (!empty($args)) {
            $this->info->widgets[$name]->setInput($args);
        }

        return $this->info->widgets[$name];
    }

    public function widget($name, $arguments=array())
    {
        if (!$this->hasWidget($name)) return false;
        
        $widget = $this->getWidget($name, $arguments);
        return $widget->build();
    }

    public function action($name, $arguments=array())
    {
        if (!$this->hasAction($name)) return false;

        $response = new stdClass();
        $response->success = true;
        $actionCanvas = $this->canvas->getAction($name);

/*
 * TODO
 *      if (!$actionCanvas->IsAuthenticated) {
            return $response;
        }
 */
        $this->module->assign = array();
        $ref = new ReflectionClass($this->module);
        $activity = $ref->getMethod($name)->invokeArgs($this->module, (array)$arguments);

        //
        // TODO: Workflow activity
        //
        // if ($actionCanvas->hasActivity($activity)) {
        //     $widget = $actionCanvas->Workflow->process($activity);
        // }
        //

        if ($actionCanvas->hasLayout) {
            $request = system_web_context_Request::Instance()->setInfo("parameters", $this->module->assign);
            $layout = new system_web_view_Layout($actionCanvas->layout);

            return $layout->build();
        }

        return $this->widget($name, $this->module->assign);
    }

    public function getData($key) 
    {
        return $this->module->assign[$key];
    }
}

?>
