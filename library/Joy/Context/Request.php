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
class Joy_Context_Request extends Joy_Context_Base
{
    protected static $_instance;

    protected $_current;
    
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

    public function setAction($controller, $action, $action_arguments=array())
    {
        $this->_current->controller = Joy_Controller::factory($controller);
        $this->_current->action->name = $action;
        $this->_current->action->arguments = (array)$action_arguments;
    }

    public function setParameters($parameters=array())
    {
        $this->_current->parameters = $parameters;
    }

    public function getMethod()
    {
        return $this->_current->method;
    }

    public function setMethod($method)
    {
        $this->_current->method = $method;
    }

    public function harness()
    {
        $response = Joy_Context_Response::getInstance();

        $view = $this->_current->controller->action($this->_current->action->name,
                                                    $this->_current->action->arguments);

        $render = $response->getRender();
        $output = $render->execute($view);

        $this->_includeResourceFiles(&$view, &$output);

        header("Content-Type: {$render->getContentType()}");
        print $output;
/*        $this->response->render->execute($view);

        $this->response->getOutput();

        $this->response->render->getContentType();*/
    }

    protected function _includeResourceFiles($view, $output)
    {
        if ($view instanceof Joy_View_Layout) 
        {
            $culture = Joy_Context_Culture::getInstance();
            $response = Joy_Context_Response::getInstance();
            $site_root = $this->config->application->get("application/site_root");

            $app_script = sprintf("%s/%s.initial.js",
                              get_class($this->_current->controller), 
                              $this->_current->action->name, 
                              $culture->getLocale());

            $page_script = sprintf("%s/%s.js", 
                               get_class($this->_current->controller), 
                               $this->_current->action->name);


            // Script Files Injection
            $scripts = $response->getScripts();
            $scripts = array_reverse($scripts);
            array_push($scripts, $app_script);
            $scripts = array_reverse($scripts);
            array_push($scripts, $page_script);

            foreach ($scripts as $script) {
                if (strpos($script, "http") === FALSE) {
                    $script = sprintf("%s/%s", $site_root, trim($script, "/"));
                }

                $page_scripts .= sprintf("<script type='text/javascript' src='%s'></script>\n", $script);
            }
            $output = str_replace("<!-- @Page.Javascripts -->", $page_scripts, $output);
            
            // Style Files Injection
            $styles = $response->getStyles();
            foreach ($styles as $style) {
                if (strpos($style, "http") === FALSE) {
                    $style = sprintf("%s/%s", $site_root, trim($style, "/"));
                }

                $page_styles .= sprintf("<link rel='stylesheet' type='text/css' href='%s' />\n", $style);
            }
            $output = str_replace("<!-- @Page.Stylesheets -->", $page_styles, $output);
        }
    }

}
