<?php

function smarty_function_link($params, &$smarty)
{
    $config = joy_Configure::getInstance();
    $site_root = $config->Get("app.site_root");

    if (isset($params["url"])) {
        $url = $params["url"];
        return sprintf("%s/%s", rtrim($site_root, '/'), ltrim($url, '/'));
    }

    //TODO: images, flashes
    if (isset($params["image"])) {
        $image = $params["image"];

        $image_root = $config->Get("app.document_root.folders.uri.image");
        return sprintf("%s/%s", rtrim($image_root, '/'), ltrim($url, '/'));
    }

}

?>
