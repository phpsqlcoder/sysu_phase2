<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Role;

class Permission extends Model
{
    use SoftDeletes;

    public $table = 'permission';

    protected $fillable = [ 'name', 'module', 'description', 'routes', 'methods', 'user_id', 'is_view_page'];

    protected $casts = [
        'routes' => 'array',
        'methods' => 'array',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission')->where('isAllowed', 1);
    }

    public function module_code()
    {
        return implode("_", explode(' ', $this->module));
    }

    public static function module_init($controller, $moduleName)
    {
        $permissions = Permission::where('module', $moduleName)->get();

        foreach ($permissions as $permission) {
            $controller->middleware('checkAccessRights:'.$permission->id, ['only' => $permission->methods]);
        }
    }

    public static function has_access_to_route($routeId)
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

    public static function modules()
    {
        return [
            'page' => 'Pages',
            'banner' => 'Banners',
            'file_manager' => 'Files',
            'menu' => 'Menu',
            'news' => 'News',
            'news_category' => 'News Category',
            'website_settings' => 'Website Settings',
            'audit_logs' => 'Audit Trail',
            'user' => 'Users',
            'product' => 'Products',
            'product_category' => 'Product Category',
            'product_reviews' => 'Product Reviews',
            'favorites' => 'Favorites',
            'wishlist' => 'Wishlist',
            'customer' => 'Customers',
            'sales_transaction' => 'Sales Transaction',
            'inventory' => 'Inventory',
            'promos' => "Promos",
            'coupons' => "Coupons",
            'reports' => 'Reports',
        ];
    }
}
