<?php


class vendors_phptal_filters_PostFilter extends joy_Object implements PHPTAL_Filter 
{
    public function filter($xhtml)
    {
        $resource = joy_web_Resource::getInstance();

        $styles =  "<!-- Include Styles -->\n";
        $styles .= implode("\n", $resource->Styles->GetAll());
        $xhtml = str_replace("__STYLE_MARKUP__", $styles, $xhtml);
        
        $scripts =  "<!-- Include Javascripts -->\n";
        $scripts .= implode("\n", $resource->Scripts->GetAll());

        $xhtml = str_replace("__JAVASCRIPT_MARKUP__", $scripts, $xhtml);

        return $xhtml;
    }
}

?>
