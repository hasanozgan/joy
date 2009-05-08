<?php

    require_once("../bootstrap.php");
echo CONFIG_SHM_KEY;
    shell_exec("ipcrm -M ".escapeshellarg(CONFIG_SHM_KEY));
    shell_exec("ipcrm -M ".escapeshellarg(NAMESPACE_SHM_KEY));

?>
