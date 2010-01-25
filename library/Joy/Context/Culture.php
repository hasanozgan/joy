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
 * @subpackage  Context
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id$
 * @link        http://joy.netology.org
 * @since       0.5
 */
class Joy_Context_Culture extends Joy_Context_Base
{
    protected static $_instance;

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

    public function __construct()
    {
        parent::__construct();
        $locale = $this->config->application->get("application/locale");

        $current = (isset($locale["current"]) ? $locale["current"] : "en-US");

        $accepted = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, strpos($_SERVER["HTTP_ACCEPT_LANGUAGE"], ","));
        if (in_array($accepted, (array)$locale["accepted"])) {
            $current = $accepted;
        }

        $this->setLocale($current);
    }

    public function getLanguage()
    {
        return $this->_language;
    }

    public function getCountry()
    {
        return $this->_country;
    }

    public function setLocale($locale)
    {
        list($this->_language, $this->_country) = split("[-_]", $locale);
        $this->_current = $this->getLocale();
    }

    public function getLocale()
    {
        return sprintf("%s-%s", $this->getLanguage(), $this->getCountry());
    }

    public function getCharset()
    {
        // @TODO
        return "UTF-8";
    }

    public function getCollate()
    {
        return "utf8_general_ci";
    }
}
