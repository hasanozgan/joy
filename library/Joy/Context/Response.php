<?php
/**
 * Joy Web Framework
 *
 * Copyright (c) 2008-2009 Netology Foundation (http://www.netology.org)
 * All rights reserved.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL.
 */

/**
 * @package     Joy
 * @subpackage  Context
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id$
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Context_Response extends Joy_Context_Base
{
    protected static $_instance;
    protected $_render;
    protected $_scripts;
    protected $_styles;
    protected $_content;

    public function getContent()
    {
        return $this->_content;
    }

    public function appendContent($content)
    {
        $this->_content .= $content; 
    }


    public function setRender($render) 
    {
        $this->_render = $render;
    }

    public function getRender() 
    {
        return $this->_render;
    }

    public function getScripts()
    {
        return $this->_scripts;
    }

    public function getStyles()
    {
        return $this->_styles;
    }

    public function addScript($scripts)
    {
        if (!is_null($scripts)) {
            $scripts = (array)$scripts;
            foreach ($scripts as $script) {
                $script = trim($script, "/");
                $this->_scripts[$script] = $script;
            }
        }
    }

    public function addStyle($styles)
    {
        if (!is_null($styles)) {
            $styles = (array)$styles;
            foreach ($styles as $style) {
                $style = trim($style, "/");
                $this->_styles[$style] = $style;
            }
        }
    }

    /**
     * getInstance
     * 
     * @return void
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}
