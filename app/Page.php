<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use SoftDeletes;

    protected $table = 'pages';
    protected $fillable = ['parent_page_id', 'album_id', 'slug', 'name', 'label', 'contents', 'status', 'page_type', 'image_url', 'meta_title', 'meta_keyword', 'meta_description', 'user_id', 'template'];

    // public function album()
    // {
    //     return $this->belongsTo(Album::class);
    // }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menus_has_pages');
    }

    public function parent_page()
    {
        return $this->hasOne(Page::class, 'id', 'parent_page_id')->where('status', 'PUBLISHED');
    }

    public function has_parent_page()
    {
        return $this->parent_page && $this->parent_page->count() > 0;
    }

    public function sub_pages()
    {
        return $this->hasMany(Page::class, 'parent_page_id')->where('status', 'PUBLISHED');
    }

    public function has_sub_pages()
    {
        return $this->sub_pages && $this->sub_pages->count() > 0;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function album()
    {
        return $this->belongsTo('App\Album')->withDefault([
            'name' => 'No album',
            'id' => '0',
        ]);
    }

    public function has_slider()
    {
        return empty($this->image_url);
    }

    public function is_published()
    {
        return strtolower($this->status) == 'published';
    }

    public function is_customize_page()
    {
        return $this->page_type == 'customize';
    }

    public function is_home_page()
    {
        return $this->id == 1;
    }

    public function is_contact_us_page()
    {
        return $this->id == 3;
    }

    public function is_standard_page()
    {
        return $this->page_type == 'standard';
    }

    public function is_not_standard_page()
    {
        return $this->page_type != 'standard';
    }

    public function is_default_page()
    {
        return $this->page_type == 'default';
    }

    public function is_not_default_page()
    {
        return $this->page_type != 'default';
    }

    public function get_url()
    {
//        if($this->parent_page) {
//            $url = $this->parent_page->slug.'/'.$this->slug;
//            $parentPage = $this->parent_page;
//            while($parentPage->parent_page_id != 0) {
//                $parentPage = $parentPage->parent_page;
//                $url = $parentPage->slug.'/'.$url;
//            }
//
//            return env('APP_URL')."/".$url;
//        }

        return env('APP_URL')."/".$this->slug;
    }

    public static function totalPages()
    {
        $total = Page::withTrashed()->get()->count();

        return $total;
    }

    public static function totalPublicPages()
    {
        $total = Page::where('status','PUBLISHED')->count();

        return $total;
    }

    public static function totalPrivatePages()
    {
        $total = Page::where('status','PRIVATE')->count();

        return $total;
    }

    public static function totalDeletePages()
    {
        $withTrashed = Page::withTrashed()->get()->count();
        $total = $withTrashed - Page::count();
        return $total;
    }

    public static function convert_to_slug($url, $parentPage = 0){
        $url = str_slug($url, '-');

        $parentPage = Page::find($parentPage);
        if($parentPage) {
            $url = $parentPage->slug.'/'.$url;
        }

        if(self::check_if_slug_exists($url)){
            $url=$url.'-2';
            return self::convert_to_slug($url);
        }
        else{
            return $url;
        }
    }

    public static function check_if_slug_exists($slug){

        if (Page::where('slug', '=', $slug)->exists()) {
            return true;
        }
        elseif (\App\Article::where('slug', '=', $slug)->exists()) {
            return true;
        }
        elseif (\App\ArticleCategory::where('slug', '=', $slug)->exists()) {
            return true;
        }
        else{
            return false;
        }
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

    public static function page_not_found()
    {
        $view404 = 'theme.'.env('FRONTEND_TEMPLATE').'.pages.404';
        if (view()->exists($view404)) {
            $page = new Page();
            $page->name = 'Page not found';
            return view($view404, compact('page'));
        }

        return abort(404);
    }
}
