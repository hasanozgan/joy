<?php

interface system_web_view_render_ITemplateEngine
{
    function Assign($key, $value);
    function Fetch($file);
}

?>
