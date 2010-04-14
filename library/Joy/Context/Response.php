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
    const PAGE_STYLESHEETS = "<!-- @@@ Page.Stylesheets @@@ -->",
          PAGE_JAVASCRIPTS = "<!-- @@@ Page.Javascripts @@@ -->";

    protected function _init()
    {
        parent::_init();
        
        $this->event->register("page.render", $this, "onRender"); 
    }

    public function onRender($output)
    {
        $js = $this->flush_javascripts();
        $css = $this->flush_stylesheets();

        $output = str_replace(self::PAGE_JAVASCRIPTS, $js, $output);
        $output = str_replace(self::PAGE_STYLESHEETS, $css, $output);
    }

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
        return (array)$this->_scripts;
    }

    public function getStyles()
    {
        return (array)$this->_styles;
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

    public function stylesheets()
    {
        print "\n";
        print self::PAGE_STYLESHEETS;
        print "\n";
    }

    protected function flush_stylesheets()
    {
        $site_root = trim($this->config->application->get("application/site_root"), "/");

        // Style Files Injection
        $styles = (array)$this->getStyles();
        foreach ($styles as $style) 
        {
            if (strpos($style, "http") === FALSE) {
                $style = ($site_root) 
                            ? sprintf("/%s/%s", $site_root, trim($style, "/"))
                            : sprintf("/%s", trim($style, "/"));
            }

            $page_styles .= sprintf("\t<link rel='stylesheet' type='text/css' href='%s' media='all' />\n", $style);
        }

        return $page_styles;
    }

    public function javascripts() 
    {
        print "\n";
        print self::PAGE_JAVASCRIPTS;
        print "\n";
    }

    protected function flush_javascripts()
    {
        $culture = Joy_Context_Culture::getInstance();
        $request = Joy_Context_Request::getInstance();
        $site_root = trim($this->config->application->get("application/site_root"), "/");

        $app_script = sprintf("%s/%s.initial.js",
                          get_class($request->getAction()->controller), 
                          $request->getAction()->action->name, 
                          $culture->getLocale());

        $page_script = sprintf("%s/%s.js", 
                           get_class($request->getAction()->controller), 
                           $request->getAction()->action->name);

        // Script Files Injection
        $scripts = (array)$this->getScripts();
        $scripts = array_reverse($scripts);
        array_push($scripts, $app_script);
        $scripts = array_reverse($scripts);
        array_push($scripts, $page_script);

        foreach ($scripts as $script) {
            if (strpos($script, "http") === FALSE) {
                $script = ($site_root) 
                            ? sprintf("/%s/%s", $site_root, trim($script, "/"))
                            : sprintf("/%s", trim($script, "/"));
            }

            $page_scripts .= sprintf("\t<script type='text/javascript' src='%s'></script>\n", $script);
        }

        return $page_scripts;
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
