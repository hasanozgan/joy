<?php
/**
 * PHPTAL templating engine
 *
 * PHP Version 5
 *
 * @category HTML
 * @package  PHPTAL
 * @author   Laurent Bedubourg <lbedubourg@motion-twin.com>
 * @author   Kornel Lesiński <kornel@aardvarkmedia.co.uk>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version  SVN: $Id: TAL.php 610 2009-05-24 00:32:13Z kornel $
 * @link     http://phptal.org/
 */

require_once 'PHPTAL/Php/Attribute/TAL/Comment.php';
require_once 'PHPTAL/Php/Attribute/TAL/Replace.php';
require_once 'PHPTAL/Php/Attribute/TAL/Content.php';
require_once 'PHPTAL/Php/Attribute/TAL/Condition.php';
require_once 'PHPTAL/Php/Attribute/TAL/Attributes.php';
require_once 'PHPTAL/Php/Attribute/TAL/Repeat.php';
require_once 'PHPTAL/Php/Attribute/TAL/Define.php';
require_once 'PHPTAL/Php/Attribute/TAL/OnError.php';
require_once 'PHPTAL/Php/Attribute/TAL/OmitTag.php';

/**
 * @package PHPTAL
 * @subpackage Namespace
 */
class PHPTAL_Namespace_Joy extends PHPTAL_Namespace
{
    public function __construct()
    {
        parent::__construct('joy', 'http://joy.netology.org/namespaces/joy');
        $this->addAttribute(new PHPTAL_NamespaceAttributeSurround('js_handler', 4));
        $this->addAttribute(new PHPTAL_NamespaceAttributeSurround('css_handler', 6));
        $this->addAttribute(new PHPTAL_NamespaceAttributeSurround('place_holder', 8));
    }

    public function createAttributeHandler(PHPTAL_NamespaceAttribute $att, PHPTAL_Dom_Element $tag, $expression)
    {
        $name = $att->getLocalName();
        
        // change define-macro to "define macro" and capitalize words
        $name = str_replace(' ', '', ucwords(strtr($name,'-',' ')));

        // case is important when using autoload on case-sensitive filesystems
        $class = 'PHPTAL_Php_Attribute_'.strtoupper($this->getPrefix()).'_'.$name;
        $result = new $class($tag, $expression);
        return $result;
    }
}
}
