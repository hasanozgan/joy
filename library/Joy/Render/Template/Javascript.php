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
 * @subpackage  Module_Render
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id$
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Render_Template_Javascript extends Joy_Render_Abstract
{
    public function __construct()
    {
        $this->response = Joy_Context_Response::getInstance();
        $this->config = Joy_Config::getInstance();
    }

    public function getContentType()
    {
        return "text/javascript";
    }

    public function execute($view)
    {
        if ($view instanceof joy_view_layout) {
            $this->execute($view->getplaceholder());
        }

        $manifest = $view->getmanifest();
        if (!empty($manifest["stacks"])) {
            foreach($manifest["stacks"] as $name => $stack) {
                $view->getstack($name);
            }
        }

        $scriptFile = $view->getScript();
        if (file_exists($scriptFile)) {
            $content = sprintf("/* %s - %s */\n", $view->getId(), get_class($view));
            $content .= file_get_contents($scriptFile);
            @preg_match_all('/\$__i18n\[[\"|\'](.+)[\"|\']\]/', $content, $matches);
            $locale = $view->getLocale();

            if (!empty($matches[1])) {
                for ($i = 0; $i < count($matches[1]); $i++) {
                    $key = $matches[1][$i];
                    $text = $locale[$key] ? $locale[$key] : $key;
                    $content = str_replace($matches[0][$i], "'{$text}'", $content);
                }
            }

            $content = str_replace("\$__i18n", $translate, $content);
            $this->response->appendContent($content);
        }

        return $this->response->getContent();
    }

}
