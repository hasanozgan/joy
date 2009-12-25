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
 * @version     $Id$
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Controller extends Joy_Controller_Abstract
{
    /**
     * factory static method is instance controller
     *
     * @param string $name is controller class name
     * @return Joy_Controller
     */
    public static function factory($name)
    {
        return Joy_Controller_Factory::getInstance()->getController($name);
    }

    /**
     * exists static method is check controller
     *
     * @param string $name is controller class name
     * @return boolean
     */
    public static function exists($name)
    {
        $ref = new Joy_Reflection($name);
        return $ref->isA(Joy_Controller_Interface);
    }

    /**
     * action method is execute action.
     *
     * @param string $name is action name
     * @param array $arguments for action
     */
    public function action($name, $arguments=array())
    {
        //switch canvas for action name...
        $this->_canvas->switchAction($name);

        // check authetication
//        if ($this->authentication($action);


        $this->_assign = array();

        $ref = new ReflectionClass($this);
        $method = sprintf("_%s", $name);

        if (!$ref->hasMethod($method) || !$ref->getMethod($method)->isProtected()) {
            throw new Joy_Exception_NotFound_Method("Action Not Found ({$method})");
        }

        // it is temporary.        
        // FIXME: ReflectionMethod class not found setAccesible method in PHP 5.2.10 version.
        // $ref->getMethod($action)->setAccessible(TRUE);
        // return $ref->getMethod($action)->invokeArgs($this, $arguments);
        $view = $this->$method($arguments);

        // has layout
        if (!is_null($layout = $this->_canvas->getLayout())) {
            $layout = new Joy_View_Layout($layout);
            $layout->setPlaceHolder($view);

            return $layout;
        }
    
        return $view;
    }
}
