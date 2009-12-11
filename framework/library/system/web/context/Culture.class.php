<?php

import("system.Object");

class system_web_context_Culture extends system_Object
{
    public $CountryCode;
    public $LanguageCode;
    public $Encoding;

    private static $_instance;

    public static function &Instance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function Init()
    {
        $config = system_Configuration::Instance();
        $accepted_languages = (array)$config->app["culture"]["languages"];

        $this->Encoding = "UTF-8";
        list($this->Locale) = split(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        list($this->LanguageCode, $this->CountryCode) = split("[-_]", $this->Locale);

        if (!in_array($this->LanguageCode, $accepted_languages)) {
            $this->setLocale($config->app["culture"]["locale"]);
        }
    }

    public function setLocale($locale)
    {
        list($this->Locale, $this->Encoding) = split("\.", $locale);
        list($this->LanguageCode, $this->CountryCode) = split("[-_]", $this->Locale);
    }
}

?>
