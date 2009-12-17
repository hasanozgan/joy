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
 * @subpackage  Router
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id$
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Router_Item
{
    /**
     * var object $info
     */
    private $_info;

    public function __construct($info)
    {
        $this->_info = $info;
        $this->_canvas = Joy_Controller_Canvas::getInstance($this->getController());
        $this->_canvas->switchAction($this->getAction());
    }

    public function getRender()
    {
        return $this->_info->render;
    }

    public function getController()
    {
        return $this->_info->controller;
    }

    public function getAction()
    {
        return $this->_info->action;
    }

    public function getArguments()
    {
        return $this->_info->action-arguments;
    }

    public function getMethod()
    {
        return $this->_info->method;
    }

    public function getParameters()
    {
        return $this->_info->parameters;
    }

    public function getTheme()
    {
        return $this->_canvas->getTheme();
    }

    public function getPage()
    {
        return $this->_canvas->getPage();
    }

    public function getLayout()
    {
        return $this->_canvas->getLayout();
    }
}
