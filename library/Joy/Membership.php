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
 * @subpackage  Membership
 * @author      Hasan Ozgan <meddah@netology.org>
 * @copyright   2008-2009 Netology Foundation (http://www.netology.org)
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version     $Id: User.php 112 2009-12-17 07:13:13Z hasanozgan $
 * @link        http://joy.netology.org
 * @since       0.5
 */

class Joy_Membership extends Joy_Object
{
    protected static $_instance;

    // access control rules
    protected $acl;

    // user profiles
    public $profiles;

    // authenticated
    protected $auth;
    
    public $id;
    public $name;
    public $email;
    public $password;
 
    public function _init()
    {
        $this->auth = false;
        $this->_membership = $this->config->application->get("application/membership");

        if ($this->_membership && $this->_membership["provider"]) {
            $ref = new Joy_Reflection($this->_membership["provider"]);
            $this->provider = $ref->newInstance();
        }
        
        $this->acl = new Joy_Membership_Acl(); // Role, Resource and Alloweds
        $this->profiles = new Joy_Membership_Profile();

//        Joy_Membership_Role;
//        Joy_Membership_Profile;
//        Joy_Membership_User;

    }

    public function login($usr, $pwd)
    {
        $session = Joy_Context_Session::getInstance();

        if ($this->provider instanceof Joy_Membership_Provider_User) {
            if ($this->provider->login($usr, $pwd)) {
                $session->set("__authenticated", true);
            }
        }

        return false;
    }

    public function logout()
    {
        $session = Joy_Context_Session::getInstance();

        $session->flush();
    }

    public function isAuthenticated()
    {
        $session = Joy_Context_Session::getInstance();

        return (bool) $session->get("__authenticated");
    }

    public function isAuthorized($role, $resource=null, $privileges=null)
    {
        return $this->acl->isAllowed($role, $resource, $privileges);
    }

}
