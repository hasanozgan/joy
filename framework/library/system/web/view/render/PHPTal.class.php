<?php

import("system.Object");
import("system.web.view.render.Base");

class system_web_view_render_PHPTal extends system_web_view_render_Base
{
    public function Init()
    {
        parent::Init();

        require_once("PHPTAL.php");
        $this->templateEngine = new PHPTAL();
    }

    public function Execute($filepath)
    {
        $this->templateEngine->setTemplate($filepath);

        return $this->templateEngine->execute();
    }
}

function phptal_tales_site_root( $src, $nothrow )
{
    $config = system_Configuration::Instance();
    $site_root = trim($config->app["site_root"], '/');

    if ($site_root) {
        $src = sprintf("string:/%s/%s", trim($config->app["site_root"], "/"), trim($src, "/"));
    }
    else {
        $src = sprintf("string:/%s", trim($src, "/"));
    }

    return phptal_tales($src, $nothrow);
}

function phptal_tales_image_root( $src, $nothrow )
{
    $config = system_Configuration::Instance();
    $site_root = trim($config->app["site_root"], '/');

    if ($site_root) {
        $src = sprintf("string:/%s/%s/%s",
                   $site_root, 
                   trim($config->app["image_path"], "/"), 
                   trim($src, "/"));
    }
    else {
        $src = sprintf("string:/%s/%s",
                   trim($config->app["image_path"], "/"), 
                   trim($src, "/"));
    }

    return phptal_tales($src, $nothrow);
}

?>
