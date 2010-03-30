<?php

class Dahius_Membership extends Joy_Module
{
    /**
     * _list is an action method
     *
     * action method must be protected mode end could be start '_' prefix.
     *
     * @return Joy_View_Interface 
     */
    protected function _login()
    {
        // rest example..
        switch ($this->request->getMethod())
        {
            case "GET":
                return new Dahius_Membership_Widget_Login();

            case "POST":

                var_dump($_REQUEST);
            die();

                break;
        }
    }    
}
