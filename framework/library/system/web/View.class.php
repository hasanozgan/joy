<?php

import("system.web.Context");
import("system.serialization.Json");

class system_web_View extends system_web_Context
{
    protected $name;
    protected $files;
    protected $folder;
    protected $template_engine;
    protected $resource_key;

    protected $input;
    protected $output;

    public function __construct($name)
    {
        $this->name = $name;

        parent::__construct();
    }

	protected function Init()
	{
        parent::Init();

        $this->folder = $this->getFolder();
        $this->resource_key = $this->getResourceKey();
    }

    protected function RegisterEvents()
    {
        $this->Event->Register("Init", "OnInit", $this); 
        $this->Event->Register("Load", "OnLoad", $this); 
        $this->Event->Register("Render", "OnRender", $this); 
        $this->Event->Register("Disposal", "OnDisposal", $this); 
    }

    protected function loadLocale()
    {
        $this->files["locale"] = sprintf("%s/%s.%s.locale", $this->folder, $this->name, $this->Culture->LanguageCode);
    }

    protected function loadResource()
    {
        $this->files["javascript"] = sprintf("%s/%s.js", $this->folder, $this->name);
        if (!file_exists($this->files["javascript"])) return;

        if (file_exists($this->files["locale"])) {
            $js_locale = sprintf("\"%s\":%s", $this->resource_key, system_serialization_Json::Encode((array)parse_ini_file($this->files["locale"])));
            $this->Response->addResource("locale.js", $this->resource_key, $js_locale);
        }

        $js_content = file_get_contents($this->files["javascript"]);
        $this->Response->addResource("js", $this->resource_key, $js_content);
    }

    protected function loadTemplate()
    {
        $this->files["template"] = sprintf("%s/%s.tpl", $this->folder, $this->name);
        $this->files["manifesto"] = sprintf("%s/%s.manifesto", $this->folder, $this->name);

        // Create template engine
        $this->template_engine = using($this->Config->framework["drivers"]["template_engine"]);

        // data assigning
        $this->template_engine->i18n($this->files["locale"]);            
        foreach ($this->output as $key=>$value) {
            $this->template_engine->assign($key, $value);
        }

        // set stack rules...
        $this->Config->LoadFile("manifesto", $this->files["manifesto"]);
        
        // add resource files
        $this->Response->addJavascript($this->Config->manifesto["javascripts"]);
        $this->Response->addStylesheet($this->Config->manifesto["stylesheets"]);

        $this->template_engine->setStackRules($this->Config->manifesto["stacks"]);
    }

    public function setInput($args) 
    {
        $this->input = (array) $args;
    }

    public function build()
    {
        $this->output = array();
//FIXME: Event Dispatcher wrong usage.
        $this->OnInit();
#$this->Event->Dispatch("Init");

        $result = "";
        if ($this->hasAuthorized()) 
        {
            $this->OnLoad();
#            $this->Event->Dispatch("Load");
            
            $this->loadLocale();
            $this->loadResource();
            $this->loadTemplate();

            // render...
            $result = $this->template_engine->fetch($this->files["template"]);
            $this->Event->Dispatch("Render", &$result);
            $this->Event->Dispatch("Disposal");
        }
        
        return $result;
    }


// {{{ Override

    protected function hasAuthorized()
    {
        // LOOK: You may be want override hasAuthorized
        return true;
    }

    protected function getFolder()
    {
        // LOOK: You may be want override getFolder
    }

    protected function getResourceKey()
    {
        // LOOK: You may be want override getResourceKey
    }


// }}}


// {{{ Events

    public function OnInit()
	{
	}

	public function OnLoad()
	{
	}
	
	public function OnRender()
	{
	}

    public function OnDisposal()
	{
	}

// }}}

}

?>
