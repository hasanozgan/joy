<?php

require_once "../config/define.php";
require_once system_path."/vendor/doctrine/Doctrine.php";

spl_autoload_register(array('doctrine', 'autoload'));
$conn = Doctrine_Manager::connection(dsn);
$conn->setCharset('utf8');
$conn->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
$conn->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);

Doctrine::generateYamlFromDb(library_path.'/models', array('doctrine'), array('generateTableClasses' => true));
Doctrine::generateModelsFromDb(library_path.'/models', array('doctrine'), array('generateTableClasses' => true,
                                                                           'baseClassesDirectory' => 'dal'));

echo "Data Access Layer & Models Created!\n";
?>
