<?php

class Joy_Application_Bootstrap extends Joy_Object
{
    protected function _registerEvents()
    {
        parent::_registerEvents();

        $this->event->register("app.start", $this, "onStart");

        $this->event->register("view.init", $this, "onView");

        $this->event->register("model.init", $this, "onModel");
    }

    public function onStart()
    {
    }

    public function onModel()
    {
    }

    public function onView()
    {
    }
}
