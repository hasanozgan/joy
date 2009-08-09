<?php

function phptal_tales_site_root($src, $nothrow)
{
    $config = joy_Configure::getInstance();
    $site_root = $config->Get("app.site_root");

    return sprintf("'%s/%s'", rtrim($site_root, '/'), ltrim($src, '/'));
}

?>
