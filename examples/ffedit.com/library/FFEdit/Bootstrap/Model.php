<?php

class FFEdit_Bootstrap_Model extends Joy_Context_Model_Bootstrap
{
    public function _init()
    {
        $this->_connection->setCollate('utf8_general_ci');
        $this->_connection->setCharset('utf8');
        $this->_connection->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $this->_connection->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);
    }
}
