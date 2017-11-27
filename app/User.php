<?php

namespace Korona;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Authenticatable implements HasRoleAndPermissionContract
{
    use HasRoleAndPermission;
    use SoftDeletes;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function profilePictureRoute()
    {
        if ($this->picture) {
            return route('image', $this);
        } else {
            return asset('images/no_profile_picture.jpg');
        }
    }
}
