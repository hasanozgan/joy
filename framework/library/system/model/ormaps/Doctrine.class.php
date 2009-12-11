<?php

import("system.model.IORMap");

class system_model_ormaps_Doctrine extends system_Object implements system_model_IORMap
{
    public function __construct()
    {
        require_once("Doctrine.php");
        spl_autoload_register(array('doctrine', 'autoload'));
    }

    public function Connection($dsn) 
    {
        $conn = Doctrine_Manager::connection($dsn);

        $conn->setCollate('utf8_general_ci');
        $conn->setCharset('utf8');

        $conn->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $conn->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);

        return $conn;
    }

    public function GetTable($name)
    {
        return Doctrine::getTable($name);
    }

    public function LoadModels()
    {
        Doctrine::loadModels(APPLICATION_ROOT."/model/dal"); 
        Doctrine::loadModels(APPLICATION_ROOT."/model"); 
    }

    public function GenerateModels()
    {
        Doctrine::generateModelsFromDb(APPLICATION_ROOT."/model", 
                                       array('doctrine'), 
                                       array('generateTableClasses' => true, 'baseClassesDirectory' => 'dal')
                                      ); 
    }
}

?>
