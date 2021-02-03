<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Album extends Model
{
    use SoftDeletes;

    protected $table = 'albums';
    protected $fillable = ['name', 'transition_in', 'transition_out', 'transition', 'type', 'banner_type', 'user_id'];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class)->orderBy('order');
    }

    public function addBanners($banners)
    {
        foreach ($banners as $key => $banner) {
            $banners[$key]['user_id'] = auth()->id();
        }

        return $this->banners()->createMany($banners);
    }

    public function animationIn()
    {
        return $this->belongsTo(Option::class, 'transition_in');
    }

    public function animationOut()
    {
        return $this->belongsTo(Option::class, 'transition_out');
    }

    public function is_main_banner()
    {
        return $this->type == 'main_banner';
    }

    private static function validator()
    {
        $minBanner = (request()->has('banner_type') && request()->banner_type == 'video') ? 1 : 1;

        return Validator::make(request()->all(), [
            'name' => 'required|max:150',
            'transition_in' => 'required',
            'transition_out' => 'required',
            'transition' => 'required|numeric|min:2|max:10',
            'banner_type' => '',
            'banners' => 'required|array|min:'.$minBanner
        ], [
            'banners.required' => 'Please upload at least '. $minBanner .' banner.',
        ], [
            'name' => 'Album name'
        ]);
    }

    private static function quick_edit_validator()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|max:150',
            'transition_in' => 'required',
            'transition_out' => 'required',
            'transition' => 'required|numeric|min:2|max:10'
        ]);
    }

    public static function has_invalid_data()
    {
        return Album::validator()->fails();
    }

    public static function has_invalid_quick_edit_data()
    {
        return Album::quick_edit_validator()->fails();
    }

    public static function get_error_messages()
    {
        return Album::validator()->messages();
    }

    public static function get_quick_edit_error_messages()
    {
        return Album::quick_edit_validator()->messages();
    }

    public function path()
    {
        return '/albums/' . $this->id;
    }

    public static function totalAlbums()
    {
        $total = Album::where('type','sub_banner')->withTrashed()->get()->count();

        return $total;
    }

    public static function totalNotDeletedAlbums()
    {
        $total = Album::where('type','sub_banner')->count();

        return $total;
    }

    public static function totalDeletePages()
    {
        $withTrashed = Album::withTrashed()->get()->count();
        $total = $withTrashed - Album::count();

        return $total;
    }

//    public function getUpdatedAtAttribute($value)
//    {
//        if ($value == null || trim($value) == '') {
//            return "-";
//        }
//        else if ($value != null && strtotime($value) < strtotime('-1 day')) {
//            return Carbon::parse($value)->isoFormat('lll');
//        }
//
//        return Carbon::parse($value)->diffForHumans();
//    }
}
