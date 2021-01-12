<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Banner extends Model
{
    use SoftDeletes;

    protected $table = 'banners';
    protected $fillable = ['album_id', 'title', 'description', 'alt','image_path', 'button_text', 'url', 'order', 'user_id'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public static function validator()
    {
        return Validator::make(request()->all(), [
            'banners.*.alt' => 'max:125',
            'banners.*.title' => 'max:65',
            'banners.*.description' => 'max:200',
            'banners.*.button_text' => 'max:30',
            'banners.*.url' => 'nullable|url'
        ], [
            'banners.*.title.max' => 'The banner title should not be greater than 65 characters.',
            'banners.*.description.max' => 'The banner description should not be greater than 200 characters.',
            'banners.*.button_text.max' => 'The banner button text should not be greater than 30 characters.',
            'banners.*.alt.max' => 'The banner alt should not be greater than 125 characters.'
        ]);
    }

    public static function has_invalid_data()
    {
        return Banner::validator()->fails();
    }

    public static function get_error_messages()
    {
        return Banner::validator()->messages();
    }

    public static function totalBanners()
    {
        $total = Banner::count();

        return $total;
    }

    public function file_name()
    {
        $path = explode('/', $this->image_path);
        $nameIndex = count($path) - 1;
        if ($nameIndex < 0)
            return '';

        return $path[$nameIndex];
    }
}
