<?php

namespace App\Services;

class RoleService extends CoreService
{
    private $role;

    public function __construct()
    {
        parent::__construct();
        
    }

    public function setRole($role)
    {
        return $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }
    
}


?>