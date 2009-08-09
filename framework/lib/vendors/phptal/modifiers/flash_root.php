<?php

function phptal_tales_flash_root($src, $nothrow)
{
    $config = joy_Configure::getInstance();
    $flash_root = $config->Get("app.document_root.folders.uri.flash");

    return sprintf("'%s/%s'", rtrim($flash_root, '/'), ltrim($src, '/'));
}

?>
