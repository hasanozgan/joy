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
 * @subpackage  Exception
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id$
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Exception_Handler
{
    /**
     * var array $_items
     */
    private $_items;

    /**
     * var object $_instance
     */
    private static $_instance;

    /**
     * getInstance
     * 
     * @return void
     */
    public function getInstance()
    {
        if (!is_object(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        parent::__construct(); 
        $routers = new Joy_Config_Section($this->config->application->get("files/config/router"));
        $items = $routers->getAll();
        foreach ($items as $key=>$item) {
            $rules = array();
            $variables = array();

            $atoms = split(DIRECTORY_SEPARATOR, trim($item["url"], DIRECTORY_SEPARATOR));
            foreach($atoms as $atom) {
                list($rules[], $variables[]) = split(":", $atom);
                
                $this->_items[$key] = array("filter"=>sprintf("^\\/%s\\/", implode("\\/", $rules)),
                                       "controller"=>$item["controller"],
                                       "action"=>$item["action"],
                                       "variables"=>$variables);
            }
        }
    }

    public function match($uri)
    {
        list($uri) = split("\&", $uri);
        list($uri) = split("\?", $uri);

        $atoms = (array) split("/", $uri);
        $uri = "";
        foreach ($atoms as $atom) {
           if (empty($atom)) continue;
           $uri .= "/$atom";
        }

        $site_root = trim($this->config->application->get("application/site_root"), DIRECTORY_SEPARATOR);

        if (!empty($site_root)) {
            $uri = sprintf("%s/", str_replace($site_root, "", trim($uri, DIRECTORY_SEPARATOR)));
        }
        else {
            $uri = sprintf("%s/", trim($uri, DIRECTORY_SEPARATOR));
        }

        if (empty($uri) || $uri == "/") {
            $uri = "//";
        }

        foreach ($this->_items as $key=>$item) {

            // check uri
            if (eregi($item["filter"], $uri)) {
                preg_match("/^{$item["filter"]}/U", $uri, $matches);
                $matched_uri = str_replace($matches[0], "", $uri);
                array_shift($matches);
                
                // match uri
                $action_arguments = array();
                if ($matched_uri != "") {
                    $action_arguments = split("/", trim($matched_uri, DIRECTORY_SEPARATOR));
                }

                // merge filter variables
                $parameters = array();
                foreach($item["variables"] as $key) {
                    if (!empty($key)) {
                        $parameters[$key] = trim(array_shift($matches), DIRECTORY_SEPARATOR);
                    }
                }

                // set controller variable
                if (!isset($item["controller"])) {
                    $item["controller"] = $parameters["controller"];
                    unset($parameters["controller"]);
                }

                // set action variable
                if (!isset($item["action"])) {
                    $item["action"] = $parameters["action"];
                    unset($parameters["action"]);
                }

                // set action arguments
                $item["action-arguments"] = array_merge(array_values((array)$parameters), (array)$action_arguments);

                // clear action from extension
                $action_info = split("\.", $item["action"]);

                 // set extension variable
                if (!isset($item["action-extension"])) {
                    $item["action-extension"] = count($action_info) 
                                                  ? implode(".", $action_info)
                                                  : null;
                }

                //set parameters
                $item["parameters"] = array_merge((array)$parameters, $_REQUEST);

                // unset filter values
                unset($item["filter"]);
                unset($item["variables"]);

                // set render variable
                if (!isset($item["render"])) {
                    $item["render"] = Joy_Render_Factory::found($item["extension"]);
                }

                // set request method
                $item["method"] = $_SERVER["REQUEST_METHOD"];                

                // controller exists
                $result = (object)$item;
                if (Joy_Controller::exists($result->controller)) {
                    break;
                }
            }
            else {
                $result = null;
            }
        }

        return (is_null($result)) ? null : (new Joy_Router_Item($result));
    }
}
