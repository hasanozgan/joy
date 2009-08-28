<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import("joy.Object");

class joy_web_httpcontext_User extends joy_Object
{
    private static $instance;

    public static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getUser($application) 
    {
    
    }
}

interface joy_web_httpcontext_IUser
{
    function isLogged();
    function hasAuthentication($permission, $grant);
    function hasAuthorization($role);

    /*
     * $this->User;
     * $this->User->id;
     * $this->User->username;
     * $this->User->email;
     * $this->User->password;
     *
     * $this->User->login($username/$email, $pass);
     * $this->User->logout();
     * $this->User->forgotPassword($email);
     * $this->User->isLogged();
     * $this->User->hasAuthentication($permission, $grant);
     * $this->User->hasAuthorization($role); // alias is hasRole method
     *
     * $this->User->Roles;
     * $this->User->hasRole(ADMIN);
     * $this->User->getRole("admin")->Permissions;
     * $this->User->getRole("admin")->hasPermission("admin:/AccountingPage/list");
     * $this->User->getRole("admin")->getPermission("admin:/AccountingPage/list")->Grants;
     * $this->User->getRole("admin")->getPermission("admin:/AccountingPage/list")->Activities;
     * $this->User->getRole("admin")->getPermission("admin:/AccountingPage/list")->hasGrant("read");
     * $this->User->getRole("admin")->getPermission("admin:/AccountingPage/list")->getActivity("read")->goProcess();
     *
     * $this->Profile;
     * $this->Profile->Gender;
     * $this->Profile->BirthDate;
     * $this->Profile->Save();
     *
     */
}

?>
