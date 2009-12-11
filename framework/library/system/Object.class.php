<?php

import("system.Configuration");
import("system.Event");

class system_Object
{
	public $Config;
	public $Event;
	public $Cache;

    public function __construct()
    {
        $this->Config = system_Configuration::Instance();
        $this->Event = system_Event::Instance();

        $this->RegisterEvents();
        $this->Init();
    }

    protected function Init()
    {
        // Inheritance
    }

    protected function RegisterEvents()
    {
        // Inheritance
    }


}

?>
