<?php
class joy_web_ui_ModuleLoader
{
    public $params;
    public $view;
    
    function __construct($viewObject) 
    {
        $this->view = $viewObject;
    }

    function __get($value)
    {
        $this->params[] = $value;
        return $this;
    }

    function load()
    {
        $receipt = joy_web_Receipt::FromURI(implode("/", $this->params));
        $receipt->OutputMode = "view";
        $receipt->Source = "Loader";
        $page = joy_web_PageFactory::Assembly($receipt);
        $page->display();
        $this->params = array();
    }

    function self()
    {
        echo $this->view->getEngine()->Fetch($this->view->getViewFilePath());
    }
}
