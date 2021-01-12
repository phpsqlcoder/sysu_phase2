<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menus';
    protected $fillable = ['name', 'is_active', 'pages_json'];

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'menus_has_pages');
    }

    public function navigation()
    {
        return $this->hasMany(MenusHasPages::class);
    }

    // public function addPages($pages)
    // {
    //     return $this->links()->createMany($pages);
    // }

    public function parent_navigation()
    {
        return $this->navigation()->where('parent_id', 0)->orderBy('page_order')->get();
    }

    private static function validator()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|max:150',
            'is_active' => 'numeric|digits_between:0,1',
            'pages_json' => 'required|JSON'
        ], [
            'pages_json.required' => 'Please add atleast one item in the menu.',
        ]);
    }

    public static function has_invalid_data()
    {
        return Menu::validator()->fails();
    }

    public static function get_error_messages()
    {
        return Menu::validator()->messages();
    }
}
