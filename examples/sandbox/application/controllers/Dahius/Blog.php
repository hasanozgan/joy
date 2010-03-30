<?php

class Dahius_Blog extends Joy_Module
{
    /**
     * _list is an action method
     *
     * action method must be protected mode end could be start '_' prefix.
     *
     * @return Joy_View_Interface 
     */
    protected function _list()
    {
        $view = new Dahius_Blog_Widget_List($data);
        $view->assign("method", "initial");

        // rest example..
        switch ($this->request->getMethod())
        {
            case "GET":
                $data["method"] = "get";
                $view->assignAll($data);
                break;
            case "PUT":
                $view->assign("method", "put");
                break;
            case "POST":
                $view->assignMerge(array("method"=>"post"));
                break;
            case "DELETE":
                $view->reset(); // Delete all assign values
                $view->assign("method", "delete");
                break;
        }

        return $view;
    }    
}
