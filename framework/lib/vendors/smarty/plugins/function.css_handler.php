<?php

function smarty_function_css_handler($params, &$smarty)
{
    echo "<link rel=\"stylesheet\" href=\"/TestPage/get.css?v=123234&f=layout&t=BlueMoon\" type=\"text/css\" />\n";
    echo "<link rel=\"stylesheet\" href=\"/TestPage/get.css?v=123234&f=view&t=common\" type=\"text/css\" />\n";
}

?>
