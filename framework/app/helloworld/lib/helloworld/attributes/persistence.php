<?php

import("joy.web.Attribute");

class helloworld_attributes_Persistence extends joy_web_Attribute 
{
    function Execute()
    {
        var_dump("Execute Persistence");
    }

}
?>
