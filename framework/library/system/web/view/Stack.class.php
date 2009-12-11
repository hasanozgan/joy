<?php

class system_web_view_Stack extends system_Object
{
    private $stacks;

    public function __construct($_stacks) 
    {
        parent::__construct();
        $this->stacks = $_stacks;
    }

    public function __get($key) 
    {
        $data = "";
        foreach ($this->stacks[$key] as $item) {
            list($module_name, $widget_name) = split("/", $item["component"]);
            $parameters = $item["parameters"];
            
            if ($module = system_module_Factory::Load($module_name)) {
                $data .= $module->widget($widget_name, $parameters);
            }
        }

        return $data;
    }
}

?>
