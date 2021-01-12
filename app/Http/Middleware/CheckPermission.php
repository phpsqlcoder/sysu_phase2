<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

use App\ViewPermissions;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission_name)
    {
        if (Auth::user()->is_an_admin()) {
            return $next($request);
        }

        $role_id = Auth::user()->role_id;

        ## check permission
        $rolepermission = ViewPermissions::where('role', $role_id)->first();

        $array_permissions = [];

        if($rolepermission) {
            $array_permissions = explode('|', $rolepermission->permissions);
        }

        if(in_array($permission_name, $array_permissions)){
            return $next($request);
        } else {
            return response('Unauthorized Access. <a href="'.route('dashboard').'">Go back to dashboard</a>', 401);
        }
    }
}
