<?php

namespace App\Http\Controllers\Cms4Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\Webfocus\Setting;
use App\Http\Requests\Front\ShareEmailRequest;
use App\Mail\ShareNewsMail;
use App\Page;
use App\User;
use App\Menu;
use App\Article;
use DB;
use Illuminate\Support\Facades\Mail;
use Response;
use Auth;
use Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ArticleFrontController extends Controller
{

    public function view($slug)
    {
        if(Auth::guest()) {
            $article = Article::where('slug',$slug)->whereStatus('Published')->first();
        } else {
            $article = Article::where('slug',$slug)->first();
        }

        if (!$article) {
            abort(404);
        }

        $breadcrumb = $this->breadcrumb($article);

        return view('theme.'.env('FRONTEND_TEMPLATE').'.main',compact('page','breadcrumb'));

    }

    public function news_list(Request $request)
    {
        $pageLimit = 5;

        /* Search Function */
        if(isset($_GET['type'])){

            if($_GET['type'] == 'searchbox'){

                $articles = Article::where(function($query){
                                    $query->where('name','like','%'.$_GET['criteria'].'%')
                                    ->orWhere('contents','like','%'.$_GET['criteria'].'%');
                                })->whereStatus('Published');


            }
            elseif($_GET['type'] == 'year'){

                $articles = Article::whereYear('date','=',$_GET['criteria'])->whereStatus('Published');

            }
            elseif($_GET['type'] == 'month'){

                $criterias = explode("-", $_GET['criteria']);
                $articles = Article::whereYear('date','=',$criterias[0])->whereMonth('date','=',$criterias[1])->whereStatus('Published');

            }
            elseif($_GET['type'] == 'category'){
                if($_GET['criteria'] == 0)
                    $articles = Article::where(function($query){
                                    $query->whereNull('category_id')->orWhere('category_id','=',0);
                                })
                                ->whereStatus('Published');
                else
                    $articles = Article::where('category_id','=',$_GET['criteria'])->whereStatus('Published');
            }
            else{
                $articles = Article::whereStatus('Published')->get();
            }
            $articles = $articles->orderBy('date','desc')
                                ->orderBy('updated_at','desc')
                                ->paginate($pageLimit);
        }
        else{
            $articles = Article::whereStatus('Published')
                                ->orderBy('date','desc')
                                ->orderBy('updated_at','desc')
                                ->paginate($pageLimit);
        }



        /* End Search function */

        $dates = $this->dates();
        $categories = $this->categories();
        $breadcrumb = $this->breadcrumb();

        $page = Page::where('slug', 'news')->first();
        // $footer = Page::where('slug', 'footer')->where('name', 'footer')->first();
        $search = ($request->has('criteria')) ? $request->criteria : "";

        // return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.news-list',compact('page', 'footer', 'articles','breadcrumb','dates','categories', 'search'))->withShortcodes();
        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.news-list',compact('page', 'articles','breadcrumb','dates','categories', 'search'))->withShortcodes();
    }

    public function dates($conditions=null) {

        if($conditions){

        }
        else{
            $years = DB::select('SELECT year(date) as yr,count(id) as total_articles FROM `articles`  where deleted_at is null and status="Published" GROUP by year(date) ORDER BY year(date)');

            $data = '<ul>';

            foreach($years as $year){
                $data .= '<li><a href="'.route('news.front.index').'?type=year&criteria='.$year->yr.'">'.$year->yr.' ('.$year->total_articles.')</a><ul>';

                $months = DB::select('SELECT year(date) as yr,month(date) as mo,count(id) as total_articles FROM `articles` WHERE year(date)="'.$year->yr.'" and deleted_at is null and status="Published" GROUP by year(date),month(date) ORDER BY month(date)');

                foreach($months as $month){
                    $data .= '<li><a href="'.route('news.front.index').'?type=month&criteria='.$year->yr.'-'.$month->mo.'">'.date("F", mktime(0, 0, 0, $month->mo, 1)).' ('.$month->total_articles.')</a></li>';
                }

                $data .= '</ul></li>';
            }

            $data .= '</ul>';
        }

        return $data;

    }

    public function categories($conditions=null){

        if($conditions){

        }
        else{
            $categories = DB::select('SELECT ifnull(c.name, "Uncategorized") as cat, ifnull(c.id,0) as cid,count(ifnull(c.id,0)) as total_articles FROM `articles` a left join article_categories c on c.id=a.category_id where a.deleted_at is null and status="Published" GROUP BY c.name,c.id ORDER BY c.name');

            $data = '<ul class="list-group">';

            foreach($categories as $category){

                $data .= '<li><a href="'.route('news.front.index').'?type=category&criteria='.$category->cid.'">'.$category->cat.' ('.$category->total_articles.')</a><li>';

            }

            $data .= '</ul>';
        }

        return $data;

    }

    public function breadcrumb($article = null){

        $crumbs = ['Home' => route('home')];
        $crumbs['News'] = route('news.front.index');

        if($article) {
            $article = Article::whereId($article)->first();
            $crumbs[$article->name] = route('news.front.show',$article->slug);
        }

        return $crumbs;

    }

    public function filter(Request $request){

        $conditions['type'] = $request->type;
        $conditions['criteria'] = $request->criteria;

        return $this->news_list($conditions);

    }

    public function news_view($slug){

        if(auth()->guest()) {
            $news = Article::where('slug','=',$slug)->whereStatus('Published')->first();
        } else {
            $news = Article::where('slug','=',$slug)->first();
        }

        if (!$news) {
            abort(404);
        }

        $latestArticles = Article::whereStatus('Published')->orderBy('date', 'desc')->take(5)->get();
        // $articleCategories = Article::leftJoin('article_categories', 'article_categories.id', 'articles.category_id')
        //     ->select([
        //         DB::raw('ifnull(article_categories.id, 0) as id'),
        //         DB::raw('ifnull(article_categories.name, "Uncategorized") as name'),
        //         DB::raw('count(ifnull(article_categories.id, 0)) as total_articles')
        //     ])->where('articles.status', 'PUBLISHED')
        //     ->groupBy(DB::raw('article_categories.name, article_categories.id'))
        //     ->orderBy(DB::raw('article_categories.name'))
        //     ->get();
        $breadcrumb = $this->breadcrumb($news->id);

        $footer = Page::where('slug', 'footer')->where('name', 'footer')->first();
        $page = $news;


        //return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.news',compact('footer', 'news', 'latestArticles', 'breadcrumb', 'page', 'articleCategories'));
        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.news',compact('footer', 'news', 'latestArticles', 'breadcrumb', 'page'));

    }

    public function news_print($slug){

        $news = Article::where('slug',$slug)->whereStatus('Published')->first();
        $page = $news;
        if (!$news) {
            abort(404);
        }

        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.news-print',compact('news', 'page'));

    }

    public function news_share($slug) {
        $news = Article::where('slug', $slug)->whereStatus('Published')->first();

        if (!$news) {
            return ['status' => 'failed'];
        }

        Mail::to(request()->email_to)->send(new ShareNewsMail(Setting::info(), $news, request()->email_from, request()->sender_name, request()->name));

        if (Mail::failures()) {
            return response()->json(['status' => 'failed', 404]);
        }

        return ['status' => 'success'];
    }

}
