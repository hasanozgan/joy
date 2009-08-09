<?php

function phptal_tales_image_root($src, $nothrow)
{
    $config = joy_Configure::getInstance();
    $image_root = $config->Get("app.document_root.folders.uri.image");

    return sprintf("'%s/%s'", rtrim($image_root, '/'), ltrim($src, '/'));
}

?>
