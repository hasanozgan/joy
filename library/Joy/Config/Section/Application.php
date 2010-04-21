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
 * @package     Config_Section
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id: $
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Config_Section_Application extends Joy_Config_Section_Abstract
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    /**
     * __loadConfig
     *
     * @param string $environment $environement should be (development, production, staging, testing)
     * @return void
     */
    public function loadConfig($environment)
    {
        $config =  Joy_Config::getInstance();
        $root_folder = $this->get("folders/root");

        $folders = (array)$config->framework->get("folders/project");
        foreach ($folders as $name => $folder) {
            $this->set("folders/{$name}", "{$root_folder}/{$folder}");
        }

        // set config files
        $config_folder = $this->get("folders/config");
        $config_files = (array) $config->framework->get("files/config");
        foreach ($config_files as $key => $file) {
            $this->set("files/config/{$key}", "{$config_folder}/{$file}");
        }

        // privileges canvas.config file
        $file = new Joy_File($this->get("files/config/privileges"));
        $this->load(array("privileges"=>$file->getReader()->toArray()));

        // load canvas.config file
        $file = new Joy_File($this->get("files/config/canvas"));
        $this->load(array("canvas"=>$file->getReader()->toArray()));

        // set application.config file
        $this->load($this->get("files/config/application"));

        // set application.{environment}.config file
        $this->load(str_replace("{environment}", $environment, $this->get("files/config/application-environment")));
    }
}
