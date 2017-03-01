<?php

namespace Korona;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Authenticatable implements HasRoleAndPermissionContract
{
    use HasRoleAndPermission;

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getShortName()
    {
        if ($this->nickname != '') {
            return $this->nickname;
        } else {
            return $this->firstname . ' ' . $this->lastname . ' s.n.';
        }
    }

    public function getFullName()
    {
        if ($this->nickname != '') {
            return $this->firstname . ' ' . $this->lastname . ' v ' . $this->nickname;
        } else {
            return $this->firstname . ' ' . $this->lastname . ' s.n.';
        }
    }

    public function getCivilName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
