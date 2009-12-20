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
 * @subpackage  View
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id: $
 * @link        http://joy.netology.org
 * @since       0.5
 */
abstract class Joy_View_Abstract implements Joy_View_Interface
{
    /**
     * var array $_assign 
     */
    protected $_assign;

    /**
     * var string $_name is file name.
     */
    protected $_name;

    /**
     * var string $_folder
     */
    protected $_folder;

    /**
     * var array $_stacks
     */
    protected $_manifesto;


    /**
     * assign method is key value data setter 
     * and parameter is just key then getter
     *
     * @param string $key is key for data array
     * @param mixed $value is data
     * @return mixed if only key setter then returned value.
     */
    public function assign($key, $value=null)
    {
        if (is_null($value)) {
            return $this->_assign[$key];
        }

        $this->_assign[$key] = $value;
    }

    /**
     * assignAll method is reset and set data.
     * and parameter is empty then getter
     *
     * @param array $data is key for data array.
     * @return array if $data param is empty then return data array
     */
    public function assignAll($data=array())
    {
        if (empty($data)) {
            return (array) $this->_assign;
        }

        $this->_assign = $data;
    }

    /**
     * assignMerge method is merge before array setter
     *
     * @param array $data is key for data array.
     * @return void
     */
    public function assignMerge($data)
    {
        $this->_assign = array_merge_recursive((array)$this->_assign, (array)$data); 
    }

    /**
     * reset method is empty data array
     *
     * @param array $data is key for data array.
     * @return void
     */ 
    public function reset()
    {
        $this->_assign = array();
    }

    /**
     * setName method is setter for file name
     *
     * @param string $file path
     * @return void
     */ 
    public function setName($name)
    {
        $this->_name = $name;
        $this->_manifesto = $this->getManifesto();
    }

    /**
     * getName method is getter file name
     *
     * @return string file name.
     */ 
    public function getName()
    {
        return $this->_name;
    }

    /**
     * setViewFolder method is setter for template folder
     *
     * @param string $folder path
     * @return void
     */ 
    public function setViewFolder($path)
    {
        $this->_folder = realpath(dirname($path));

        $this->_manifesto = $this->getManifesto();
    }

    /**
     * getViewFolder method is getter template folder
     *
     * @return string folder path.
     */ 
    public function getViewFolder()
    {
        return $this->_folder;
    }

    /**
     * getTemplate method is getter for template file
     *
     * @return string file path. 
     */
    public function getTemplate()
    {
        return sprintf("%s/%s.tpl", $this->getViewFolder(), $this->getName());
    }

    /**
     * getLocale method is getter {name}.{language}.locale file
     *
     * @return string locale file path
     */ 
    public function getLocale()
    {
        $context = Joy_Context::getInstance();
       
        return sprintf("%s/%s.%s.locale", $this->getViewFolder(), $this->getName(), $context->culture->getLanguage());
    }

    /**
     * getLocale method is getter javascript file
     *
     * @return string locale file path
     */ 
    public function getScript()
    {
        return sprintf("%s/%s.js", $this->getViewFolder(), $this->getName());
    }

    /**
     * getResourceList method returns script and style list.
     *
     * @return array format {"javascripts"=>array(), "stylesheets"=>array()}
     *
     */
    public function getResourceList()
    {
        return array("stylesheets" => $this->_manifesto["stylesheets"],
                     "javascripts" => $this->_manifesto["javascripts"]);
    }

    /**
     * getStack method returns Joy_View_Stack type.
     *
     * @param string $name found stacklist from manifesto file.
     * @return Joy_View_Stack type
     */
    public function getStack($name)
    {
        $stackOrder = $this->_manifesto->get("stacks/{$name}");
        var_dump($stackOrder);

        return new Joy_View_Stack($stackOrder);
    }

    /**
     * getManifesto method is manifesto file.
     *
     * @return  array manifesto data
     */ 
    public function getManifesto()
    {
        if (!(is_null($this->getName()) || is_null($this->getViewFolder()))) {
            $manifesto = sprintf("%s/%s.manifesto", $this->getViewFolder(), $this->getName());

            try {
                $file = new Joy_File($manifesto);
                return $file->getReader()->toArray();
            }
            catch (Joy_Exception $ex) {
            }
        }

        return null;
    }

}
