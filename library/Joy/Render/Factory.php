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
 * @subpackage  Render
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id$
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Render_Factory
{
    public static function found($extension)
    {
        $config = Joy_Config::getInstance();
        $framework_extensions = array_values((array)$config->framework->get("extensions"));
        $application_extensions = array_values((array)$config->application->get("extensions"));
        $extensions = array_merge($framework_extensions, $application_extensions);

        foreach ($extensions as $item) {
            $filter = trim($item["filter"], DIRECTORY_SEPARATOR);

            if (eregi($filter, $extension)) {
                // has render arguments
                if (count($item["render-arguments"])) {
                    preg_match("/^{$filter}/U", $extension, $matches);
                    array_shift($matches);
                    $item["render-arguments"] = array_combine((array)$item["render-arguments"], $matches);
                }

                return $item;
            }
        }

        // default variable 
        $default = array();
        $default["render"] = Joy_Render_Template;

        return $default;
    }

    public static function get($extension)
    {
        $item = self::found($extension);

        $render = self::newInstance($item["render"]);
        $render->setParams($item["render-arguments"]);

        if ($item["cache"]) {
            $cache = Joy_Cache::factory($item["cache.source"]);
            $cache->setDuration($item["cache.duration"]);
            $render->setCache($cache);
        }

        return $render;
    }

    public static function newInstance($class)
    {
        $ref = new Joy_Reflection($class);
        return $ref->newInstance();
    }

}
