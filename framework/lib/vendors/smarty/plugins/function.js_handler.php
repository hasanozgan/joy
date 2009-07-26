<?php

function smarty_function_js_handler($params, &$smarty)
{
    echo "<script text=\"text/javascript\" src=\"/TestPage/get.js?v=1234453404&f=layout&t=BlueMoon\"></script>\n";
    echo "<script text=\"text/javascript\" src=\"/TestPage/get.js?v=1234453404&f=view&t=common\"></script>\n";
}

?>
