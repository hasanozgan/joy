<?php

interface system_model_IORMap
{
    public function GetTable($name);
    public function Connection($dsn);
    public function GenerateModels();
    public function LoadModels();
}

?>
