<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

using("joy.web.ui");

interface joy_web_ui_IPage
{
    function preAction($action);
    function postAction($action);
    function setPageArguments($args);
}


?>
