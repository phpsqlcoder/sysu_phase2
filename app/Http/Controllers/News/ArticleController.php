<?php

namespace App\Http\Controllers\News;

use App\Helpers\ListingHelper;
use App\Helpers\ModelHelper;
use App\Http\Controllers\Controller;
use App\Article;
use App\ArticleCategory;
use DB;
use Response;
use Auth;
use Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ArticlePost;
use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{

    private $searchFields = ['name'];
    private $advanceSearchFields = ['teaser', 'is_featured', 'name', 'contents', 'status', 'meta_title', 'meta_keyword', 'meta_description', 'user_id', 'category_id', 'updated_at1', 'updated_at2'];

    public function __construct()
    {
        $this->middleware('checkPermission:admin/news', ['only' => ['index']]);
        $this->middleware('checkPermission:admin/news/create', ['only' => ['create','store']]);
        $this->middleware('checkPermission:admin/news/edit', ['only' => ['show','edit','update']]);
        $this->middleware('checkPermission:admin/news/delete', ['only' => ['destroy']]);
    }

    public function index($param = null)
    {
        $listing = new ListingHelper();

        $news = $listing->simple_search(Article::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);

        // Advance search init data
        $advanceSearchData = $listing->get_search_data($this->advanceSearchFields);
        $uniqueNewsByCategory = $listing->get_unique_item_by_column(Article::class, 'category_id');
        $uniqueNewsByUser = $listing->get_unique_item_by_column(Article::class, 'user_id');

        $searchType = 'simple_search';

        return view('admin.news.index',compact('news','filter', 'advanceSearchData', 'uniqueNewsByCategory', 'uniqueNewsByUser', 'searchType'));
    }

    public function advance_index(Request $request)
    {
        $equalQueryFields = ['album_id', 'status', 'user_id'];

        $listing = new ListingHelper();
        $news = $listing->advance_search(Article::class, $this->advanceSearchFields, $equalQueryFields);

        $filter = $listing->get_filter($this->searchFields);

        $advanceSearchData = $listing->get_search_data($this->advanceSearchFields);
        $uniqueNewsByCategory = $listing->get_unique_item_by_column(Article::class, 'category_id');
        $uniqueNewsByUser = $listing->get_unique_item_by_column(Article::class, 'user_id');

        $searchType = 'advance_search';

        return view('admin.news.index',compact('news','filter', 'advanceSearchData', 'uniqueNewsByCategory', 'uniqueNewsByUser', 'searchType'));
    }

    public function create()
    {
        $categories = ArticleCategory::all();
        return view('admin.news.create',compact('categories'));

    }


    public function store(ArticlePost $request)
    {

        $image_url = '';
        if($request->hasFile('news_image'))
        {
            $newFile = $this->upload_file_to_storage('news_image', $request->file('news_image'));
            $image_url = $newFile['url'];
        }

        Article::create([
            'slug' => ModelHelper::convert_to_slug(Article::class, $request->news_title),
            'date' => $request->date,
            'name' => $request->news_title,
            'contents' => $request->content,
            'teaser' => $request->teaser,
            'status' => (isset($request->visibility) ? 'Published' : 'Private'),
            'is_featured' => (isset($request->is_featured) ? '1' : '0'),
            'image_url' => $image_url,
            'category_id' => $request->category,
            'meta_title' => $request->seo_title,
            'meta_keyword' => $request->seo_keywords,
            'meta_description' => $request->seo_description,
            'user_id' => Auth::id(),
        ]);

        // if ($this->login_user_is_a_contributor()) {
        //     $approvers  = User::where('role_id', 2)->get();

        //     foreach ($approvers as $approver) {
        //         \Mail::to($approver->email)->send(new UpdatePasswordMail(Setting::info(), $approver));
        //     }
        // }

        return redirect()->route('news.index')->with('success', __('standard.news.article.create_success'));
    }

    public function edit($id)
    {
        $article = Article::where('id',$id)->first();
        $categories = ArticleCategory::all();

        return view('admin.news.edit',compact('article','categories'));
    }


    public function update(ArticlePost $request, Article $news)
    {
        $article = $news;
        $image_url = $article->image_url;

        if (isset($request->delete_image)) {
            $image_url = '';
            Storage::disk('public')->delete($article->get_image_url_storage_path());
        }

        if ($request->hasFile('news_image')) {
            Storage::disk('public')->delete($news->get_image_url_storage_path());

            $image_url = $this->upload_file_to_storage('news_image', $request->file('news_image'), 'url');
        }

        if($article->name == $request->news_title){
            $slug = $article->slug;
        }
        else{
            $slug = \App\Page::convert_to_slug($request->news_title);
        }

        $news->update([
            'slug' => $slug,
            'name' => $request->news_title,
            'date' => $request->date,
            'contents' => str_replace(['<p>','</p>'],'',$request->content),
            'teaser' => $request->teaser,
            'status' => (isset($request->visibility) ? 'Published' : 'Private'),
            'is_featured' => (isset($request->is_featured) ? '1' : '0'),
            'image_url' => $image_url,
            'category_id' => $request->category,
            'meta_title' => $request->seo_title,
            'meta_keyword' => $request->seo_keywords,
            'meta_description' => $request->seo_description,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', __('standard.news.article.update_success'));
    }

    public function show($id)
    {

    }

	public function get_slug(Request $request)
    {
        return ModelHelper::convert_to_slug(Article::class, $request->url);
    }



    public function view($slug){

        $article = Article::where('slug',$slug)->first();

        $breadcrumb = $this->breadcrumb($article);

        return view('theme.'.env('FRONTEND_TEMPLATE').'.main',compact('page','breadcrumb'));

    }

    public function front_news_list(){

        $articles = Article::all();

        $breadcrumb = $this->breadcrumb();

        $dates = DB::select('SELECT distinct year(date) as yr, month(date) as mo FROM `articles` ORDER BY year(date), month(date)');
        $date = collect($dates);
        $years = $date->unique('yr')->all();

        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.news-list',compact('articles','breadcrumb','years'));

    }

    public function breadcrumb($article = null){

        $crumbs = ['home' => '/home'];

        if($article){
            array_push($crumbs, $article->name , '/news/'.$article->slug);
        }
        else{
            array_push($crumbs, 'Articles' , '/news-list/');
        }

        return $crumbs;

    }

    public function search(){

        $params = Input::all();

        return $this->index($params);

    }

    public function change_status(Request $request){

        $pages = explode("|",$request->pages);
        logger($pages);
        foreach($pages as $page){

            $publish = Article::where('status','!=',$request->status)
            ->whereId($page)
            ->update([
                'status' => $request->status
            ]);

        }

        return back()->with('success', __('standard.news.article.status_success', ['STATUS' => $request->status]));

    }

    public function delete(Request $request){

        $pages = explode("|",$request->pages);

        foreach($pages as $page){
            $news = Article::whereId($page);

            $news->update(['status' => 'PRIVATE']);

            $news->delete();
        }

        return back()->with('success',  __('standard.news.article.delete_success'));

    }

    public function restore($page){

        $restorePage = Article::whereId($page)->restore();

        return back()->with('success', __('standard.news.article.restore_success'));
    }

    public function login_user_is_a_contributor()
    {
        return auth()->user()->role_id == 3;
    }

    public function upload_file_to_storage($folder, $file, $key = '') {

        $fileName = $file->getClientOriginalName();
        if (Storage::disk('public')->exists($folder.'/'.$fileName)) {
            $fileNames = explode(".", $fileName);
            $count = 2;
            $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
            while(Storage::disk('public')->exists($folder.'/'.$newFilename)) {
                $count += 1;
                $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
            }

            $fileName = $newFilename;
        }

        $path = Storage::disk('public')->putFileAs($folder, $file, $fileName);
        $url = Storage::disk('public')->url($path);
        $returnArr = [
            'name' => $fileName,
            'url' => $url
        ];

        if ($key == '') {
            return $returnArr;
        } else {
            return $returnArr[$key];
        }
    }
}
