<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    public $table = 'role';

    protected $fillable = [ 'name', 'description', 'created_by',];

    public function is_admin() {
        return $this->id == 1;
    }

    public function is_not_admin() {
        return $this->id != 1;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission')->where('isAllowed', 1);
    }

    public static function has_permission_to_route($routeId)
    {
        if (auth()->check())
        {
            $userPermissions = auth()->user()->assign_role->permissions;
            if ($userPermissions->count())
            {
                $permissionIds = $userPermissions->pluck('id')->toArray();

                return (in_array($routeId, $permissionIds));
            }
        }

        return false;
    }
}
