<?php

interface Joy_Membership_Provider_User
{
    public function login($usr, $pwd);
    public function logout();
}
