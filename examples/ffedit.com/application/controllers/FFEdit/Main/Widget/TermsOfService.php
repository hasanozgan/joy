<?php

class FFEdit_Main_Widget_TermsOfService extends FFEdit_Main_Widget
{
    protected function onInit()
    {
        // Require parameters
        $this->setName("TermsOfService");
        $this->setViewFolder(__FILE__);
    }

    public function onLoad()
    {
        $culture = Joy_Context_Culture::getInstance();
        $terms = $this->models->contents->findByDql("where slug=? and language=?", array("terms-of-service",
                                                                                         $culture->getLanguage()));

        if (count($terms) > 0) {
            $this->assign("content", $terms[0]);
        }
    }
}
