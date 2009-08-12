<?php

function phptal_tales_import($src, $nothrow)
{
    ob_start();

    $uri = trim($src);
    $meta = joy_web_PageFactory::PreparePageMeta("/$uri");
    $meta->OutputMode = joy_web_ui_RenderFactory::VIEW;
    $meta->Source = "Template";
    joy_web_PageFactory::Loader($meta);
    
    $output = ob_get_contents();
    ob_end_clean();

    return phptal_tales(sprintf("string: %s", $output), $nothrow);
}

?>
