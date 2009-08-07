<?php

function smarty_function_place_holder($params, &$smarty)
{
    echo $smarty->get_template_vars("ACTION_OUTPUT");
}

?>
