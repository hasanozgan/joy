<?php

class FFEdit_Bootstrap extends Joy_Application_Bootstrap
{
    public function onStart()
    {
        $model = Joy_Context_Model::getInstance();
        $model->setBootstrap(FFEdit_Bootstrap_Model);

//      $router = Joy_Router::getInstance();
//      $router->resetItems();
//      $router->addItem(new Joy_Router_Item("/hello", "FFEdit_Subscription", "list"));

//        $view = Joy_View::getInstance();
//        $view->setBootstrap(FFEdit_Bootrap_View);
    }
}
