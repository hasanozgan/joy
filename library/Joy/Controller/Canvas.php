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
 * @subpackage  Controller
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id$
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Controller_Canvas extends Joy_Object
{
    private $_name;
    private $_data;
    protected static $_instance;

    /**
     * getInstance
     * 
     * @param string $name You could give module classname
     * @return Joy_Controller_Canvas 
     */
    public static function getInstance($name)
    {
        if (!is_object(self::$_instance[$name])) {
            self::$_instance[$name] = new self($name);
        }

        return self::$_instance[$name];
    }

    public function __construct($module)
    {
        parent::__construct();
        $this->_name = $module;
        $this->_data = $this->config->application->get("canvas/{$module}");
        $this->reset();
    }

    public function reset()
    {
        $this->_current["page"] = ((empty($this->_data["page"]) || ($this->_data["page"] == "none")) ? Joy_Page : $this->_data["page"]);
        $this->_current["layout"] = (($this->_data["layout"] == "none") ? null : $this->_data["layout"]);
        $this->_current["roles"] = (array)$this->_data["roles"];
        $this->_current["theme"] = $this->_data["theme"];   
    }

    public function switchAction($name)
    {
        $this->reset();
        $section = $this->_data["actions"][$name];

        if (isset($section["page"])) { 
            $this->_current["page"] = $section["page"];
        }

        if (isset($section["layout"])) {
            $this->_current["layout"] = (($section["layout"] == "none") ? null : $section["layout"]);
        }
        
        if (isset($section["roles"])) {
            $this->_current["roles"] = $section["roles"];
        }

        if (isset($section["theme"])) {
            $this->_current["theme"] = $section["theme"];   
        }
    }

    public function getRoles()
    {
        return (array)$this->_current["roles"];
    }

    public function getPage()
    {
        return $this->_current["page"];
    }

    public function getTheme()
    {
        return $this->_current["theme"];
    }

    public function getLayout()
    {
        return $this->_current["layout"];
    }
}
