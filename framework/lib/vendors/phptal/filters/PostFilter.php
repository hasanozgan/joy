<?php

class vendors_phptal_filters_PostFilter extends joy_Object implements PHPTAL_Filter 
{
    public function filter($xhtml)
    {
//        $render = joy_web_Render::getInstance();
//        $aa = $render->Fetch("aa.xhtml");

        $styles =  "<!-- Include Styles -->";
        $xhtml = str_replace("__STYLE_MARKUP__", $styles, $xhtml);
        
        $scripts =  "<!-- Include Javascripts -->";
        $xhtml = str_replace("__JAVASCRIPT_MARKUP__", $scripts, $xhtml);

        return $xhtml;
    }
}

?>
