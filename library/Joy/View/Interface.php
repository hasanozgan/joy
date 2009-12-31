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
interface Joy_View_Interface
{
    /**
     * assign method is key value data setter 
     * and parameter is just key then getter
     *
     * @param string $key is key for data array
     * @param mixed $value is data
     * @return mixed if only key setter then returned value.
     */
    public function assign($key, $value=null);

    /**
     * assignAll method is reset and set data.
     * and parameter is empty then getter
     *
     * @param array $data is key for data array.
     * @return array if $data param is empty then return data array
     */
    public function assignAll($data=array());

    /**
     * assignMerge method is merge before array setter
     *
     * @param array $data is key for data array.
     * @return void
     */
    public function assignMerge($data);

    /**
     * reset method is empty data array
     *
     * @param array $data is key for data array.
     * @return void
     */ 
    public function reset();

    /**
     * getmanifest method is manifest file.
     *
     * @return string manifest file path
     */ 
    public function getmanifest();

    /**
     * getViewFolder method is getter template folder
     *
     * @return string folder path.
     */ 
    public function getViewFolder();

    /**
     * setViewFolder method is setter for template folder
     *
     * @param string $folder path
     * @return void
     */ 
    public function setViewFolder($folder);

    /**
     * getTemplate method is getter for template file
     *
     * @return string file path. 
     */
    public function getTemplate();

    /**
     * setName method is setter for file name
     *
     * @param string $file path
     * @return void
     */ 
    public function setName($name);

    /**
     * getName method is getter file name
     *
     * @return string file name.
     */ 
    public function getName();

    /**
     * getLocale method is getter {name}.{language}.locale file
     *
     * @return string locale file path
     */ 
    public function getLocale();

    /**
     * getLocale method is getter javascript file
     *
     * @return string locale file path
     */ 
    public function getScript();

    /**
     * getResourceList method returns script and style list.
     *
     * @return array format {"javascripts"=>array(), "stylesheets"=>array()}
     *
     */
    public function getResourceList();

    /**
     * getStack method returns Joy_View_Stack type.
     *
     * @param string $name found stacklist from manifest file.
     * @return Joy_View_Stack type
     */
    public function getStack($name);
}
