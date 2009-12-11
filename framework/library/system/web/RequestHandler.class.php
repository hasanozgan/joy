<?php

/**
 * (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

import("system.Object");
import("system.web.Context");

class system_web_RequestHandler extends system_Object
{	
	public function Start()
	{
/*        $router = using("system.web.context.Router");
        $page = $router->createPage($_SERVER["REQUEST_URI"]);
        $page->build();
        die();*/
        // Context
        $context =& system_web_Context::Instance();
        $request = $context->Router->Find($_SERVER["REQUEST_URI"]);

        // set Request Info
        $context->Request->setInfo($request);

        // Set Language
        if ($request->language) {
            $context->Culture->setLocale($request->language);
        }
 
        // Load Module 
        if ($module = system_module_Factory::Load($request->module)) {
            $response = ($request->kind == RequestType::WIDGET) 
                            ? $module->widget($request->action, $request->arguments)
                            : $module->action($request->action, $request->arguments);
        }
 
        // response not found
        if (!$response) {
#           header("Location: {$this->Config->app["site_root"]}404-not-found");
#            die();
            // not found
            header('HTTP/1.1 404 Not Found');
            header('Status: 404 Not Found');
            exit("<h1>{$request->module}/{$request->action}.{$request->kind} not found</h1>");
        } 
      
        if ($request->content == "resource") {
            $type = ($request->language) ? "locale.js" : "js"; 
            $resources = $context->Response->getResource($type);
            $output = ($request->language) 
                            ? sprintf("var __i18n = { %s };", implode(",", (array)$resources))
                            : implode("\n", (array)$resources);

            header('Content-type: text/javascript; charset=utf-8');
            exit($output);
        }
        else {
            header('Content-type: text/html; charset=utf-8');
            $config = system_Configuration::Instance();
            $template = sprintf("/%s/%s.{extension}/%s", $request->module, $request->action, implode("/", $request->arguments));
            $lang = $context->Culture->LanguageCode;
            $js_locale_file = str_replace("{extension}", $context->Culture->LanguageCode.".js", $template);
            $js_file = str_replace("{extension}", "js", $template);
            $context->Response->addJavascript( $js_locale_file );
            $context->Response->addJavascript( $js_file );

            $response = str_replace("<!-- @Page.Javascripts -->",
                                            $context->Response->declareJavascripts(), $response);

            $response = str_replace("<!-- @Page.Stylesheets -->",
                                            $context->Response->declareStylesheets(), $response);

            exit($response);
        // seconds, minutes, hours, days
        // $expires = 60*60*24*14;
        // header("Pragma: public");
        // header("Cache-Control: maxage=".$expires);
        // header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');

        //header('WWW-Authenticate: Basic realm="'. utf8_decode($text) .'"');
        //header('HTTP/1.0 401 Unauthorized');
        //$_SERVER['PHP_AUTH_PW'];

#            var_dump($module->getData("event_id"));
#            var_dump($request, system_web_context_Response::Instance());
#            
        }        
	}
}

?>
