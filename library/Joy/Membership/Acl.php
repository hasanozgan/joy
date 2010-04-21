<?php

class Joy_Membership_Acl extends Joy_Object
{
    protected $_acl;

    public function _init()
    {
        parent::_init();
        $this->_acl = new Zend_Acl();

        $roles = $this->config->application->get("privileges/privileges/roles");

        foreach ($roles as $role=>$parent) {
            $this->addRole($role, (array)$parent);
        }

        $order = $this->config->application->get("privileges/privileges/order");

        foreach ($order as $type) {
            $rule = $this->config->application->get("privileges/privileges/$type");
            foreach ($rule as $role => $resources) {
                if (count($resources) > 0) {
                    foreach ($resources as $resource => $privileges) {
                        if (!$this->hasResource($resource)) {
                            $this->addResource($resource);
                        }

                        $this->addRule($type, $role, $resource, $privileges);
                    }
                }
                else {
                    if (!$this->hasResource("*")) {
                        $this->addResource("*");
                    }
                   
                    // add Rule
                    $this->addRule($type, $role, "*");
                }
            }
        }
    }

    public function hasRole($role)
    {
        return $this->_acl->hasRole($role);
    }

    public function addRole($role, $parents=null)
    {
        $this->_acl->addRole(new Zend_Acl_Role($role), $parents);
    }

    public function hasResource($resource)
    {
        return $this->_acl->has($resource);
    }

    public function addResource($resource)
    {
        $this->_acl->add(new Zend_Acl_Resource($resource));
    }

    public function addRule($type, $role=null, $resource=null, $privileges=null)
    {
        if ($type == "allow") {
            $this->_acl->allow($role, $resource, $privileges);
        }
        else {
            $this->_acl->deny($role, $resource, $privileges);
        }
    }

    public function isAllowed($role, $resource=null, $privileges=null)
    {
        if (!$this->_acl->has($resource)) { $resource = "*"; }
        return $this->_acl->isAllowed($role, $resource, $privileges);
    }

    public function isDenied($role, $resource=null, $privileges=null)
    {
        if (!$this->_acl->has($resource)) { $resource = "*"; }

        return $this->_acl->isDenied($role, $resource, $privileges);
    }

}
