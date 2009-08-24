<?php


class vendors_phptal_filters_PostFilter extends joy_Object implements PHPTAL_Filter 
{
    public function filter($xhtml)
    {
/*        $resource = joy_web_Resource::getInstance();
      $scriptList = $resource->Scripts->GetAll();

        $styles =  "\n<!-- Include Styles -->\n";
        $styleList = $resource->Styles->GetAll();
        foreach ($styleList as $style) {
            $styles .= sprintf("<link type='text/css' rel='stylesheet' src='%s'/>\n", $style);
        }
        $styles .= "<!-- End Include Styles -->\n";
        $xhtml = str_replace("__STYLE_MARKUP__", $styles, $xhtml);
        
        $scripts = "\n<!-- Start Include Javascripts -->\n";
        $scriptList = $resource->Scripts->GetAll();
        foreach ($scriptList as $script) {
            $scripts .= sprintf("<script type='text/javascript' src='%s'></script>\n", $script);
        }
        $scripts .= "<!-- End Include Javascripts -->\n";
        $scriptList = $resource->Scripts->GetAll();
        $xhtml = str_replace("__JAVASCRIPT_MARKUP__", $scripts, $xhtml);
*/
        return $xhtml;
    }
}

?>
