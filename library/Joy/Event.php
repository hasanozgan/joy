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
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id: $
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Event
{
    /**
     * var object $_instance
     */
    private static $_instance;

    /**
     * var array $_events
     */
    protected $_events;

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

    /**
     * register
     *
     * @param string $name Event name 
     * @param object $object Registered object
     * @param string $method Method Name
     * @return void
     */
    public function register($name, $object, $method)
    {
        $this->_events[$name][] = array("object"=>$object, "method"=>$method);
    }

    /** 
     * dispatcher
     *
     * @param object $source Which is object throwing?
     * @param string $event Event name
     * @param array $args
     * @return void
     */
    public function dispatcher($source, $name, $args=array())
    {
        if (!empty($this->_events[$name])) {
            foreach ($this->_events[$name] as $item) { 
                $ref = new ReflectionClass($item["object"]);
                $ref->getMethod($item["method"])->invoke($item["object"], &$source, &$args);
            }
        }
    }
}
