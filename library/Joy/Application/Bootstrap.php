<?php

class Joy_Application_Bootstrap extends Joy_Object
{
    protected function _registerEvents()
    {
        parent::_registerEvents();

        $this->event->register("app.start", $this, "onStart");
        $this->event->register("view.init", $this, "onView");
    }

    public function onStart()
    {
    }

    public function onView()
    {
    }
}
