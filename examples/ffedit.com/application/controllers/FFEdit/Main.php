<?php

class FFEdit_Main extends Joy_Module
{
    protected function _index()
    {
        $view = new FFEdit_Main_Widget_TermsOfService();

        return $view;
    }

    protected function _menu()
    {
    }    

    protected function _search($query="") 
    {
    }
}
