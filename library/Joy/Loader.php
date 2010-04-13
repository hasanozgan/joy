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

class Joy_Loader
{
    /**
     * run
     *
     * @return void
     */
    public static function run()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * autoload
     *
     * @param string $class
     * @return void
     */
    public static function autoload($class)
    {
        if (!class_exists($class)) {
            $include_path = get_include_path();
            $pathList = explode(":", $include_path);
            foreach($pathList as $path) {
                $classpath = sprintf("%s/%s.php", $path, str_replace("_", DIRECTORY_SEPARATOR, $class));
                
                if (file_exists($classpath)) {
                    break;
                }
            }

            if (!file_exists($classpath)) {
                throw new Joy_Exception_NotFound_Class("Class Not Found ({$class})");
            }

            require_once $classpath;
        }
    }
}


