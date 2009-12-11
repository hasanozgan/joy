<?php

import("system.web.Context");

class system_web_ui_Page extends system_web_Context
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();
        $this->order = $order;
    } 

    public function build()
    {
        var_dump($this->order);
    }
}


