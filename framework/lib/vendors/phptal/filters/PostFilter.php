<?php


class vendors_phptal_filters_PostFilter extends joy_Object implements PHPTAL_Filter 
{
    public function filter($xhtml)
    {
//        $render = joy_web_Render::getInstance();

        $resource = joy_web_Resource::getInstance();

        $styles =  "<!-- Include Styles -->";
        $styles .= implode("\n", $resource->Styles->GetAll());
        $xhtml = str_replace("__STYLE_MARKUP__", $styles, $xhtml);
        
        $scripts =  "<!-- Include Javascripts -->";
        $scripts .= implode("\n", $resource->Scripts->GetAll());

        $xhtml = str_replace("__JAVASCRIPT_MARKUP__", $scripts, $xhtml);

        return $xhtml;
    }
}

?>
