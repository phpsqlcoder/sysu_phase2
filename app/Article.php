<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';
    protected $fillable = ['date', 'teaser', 'is_featured', 'slug', 'name', 'contents', 'status', 'image_url', 'meta_title', 'meta_keyword', 'meta_description', 'user_id', 'category_id'];

    public static function base_front_url()
    {
        return env('APP_URL')."/news/";
    }

    public static function totalArticles()
    {
        $total = Article::count();

        return $total;
    }

    public static function totalPublishedArticles()
    {
        $total = Article::where('status','Published')->count();

        return $total;
    }

    public static function totalDraftArticles()
    {
        $total = Article::where('status','Private')->count();

        return $total;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\ArticleCategory')->withDefault([
            'name' => 'Uncategorized',
            'id' => '0',
        ]);
    }

    public function get_url()
    {

        return env('APP_URL')."/news/".$this->slug;
    }

    public function get_created_at_date_only()
    {
        return Carbon::parse($this->created_at)->toFormattedDateString();
    }

    public function get_image_url_storage_path()
    {
        $delimiter = 'storage/';
        if (strpos($this->image_url, $delimiter) !== false) {
            $paths = explode($delimiter, $this->image_url);
            return $paths[1];
        }

        return '';
    }

    public function get_image_file_name()
    {
        $path = explode('/', $this->image_url);
        $nameIndex = count($path) - 1;
        if ($nameIndex < 0)
            return '';

        return $path[$nameIndex];
    }
}
