<?php

namespace App\Http\Controllers\News;

use App\Helpers\ListingHelper;
use App\Helpers\ModelHelper;
use App\Http\Controllers\Controller;
use App\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ArticleCategoryRequest;

class ArticleCategoryController extends Controller
{
    private $searchFields = ['name'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $listing = new ListingHelper();

        $categories = $listing->simple_search(ArticleCategory::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);

        $searchType = 'simple_search';

        return view('admin.maintenance.article.index',compact('categories','filter', 'searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.maintenance.article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCategoryRequest $request)
    {
        $category = ArticleCategory::create([
            'name' => $request->category_name,
            'slug' => \App\Page::convert_to_slug($request->category_name),
            'user_id'  => auth()->user()->id
        ]);

        return redirect()->route('news-categories.index')->with('success', __('standard.news.category.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ArticleCategory $articleCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ArticleCategory $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articleCategory = ArticleCategory::findOrFail($id);

        return view('admin.maintenance.article.edit',compact('articleCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleCategoryRequest $request, $id)
    {
        $articleCategory = ArticleCategory::findOrFail($id);

        if($articleCategory->name == $request->category_name){
            $slug = $articleCategory->slug;
        }
        else{
            $slug = \App\Page::convert_to_slug($request->category_name);
        }

        $articleCategory->update([
            'name' => $request->category_name,
            'slug' => $slug,
            'user_id' => auth()->user()->id
        ]);

        return back()->with('success', __('standard.news.category.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ArticleCategory $articleCategory
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $articleCategory = ArticleCategory::findOrFail($request->id);
        $articleCategory->update([ 'user_id' => auth()->user()->id ]);
        $articleCategory->delete();

        return back()->with('success', __('standard.news.category.delete_success'));
    }

    public function delete(Request $request)
    {
        //logger($request);
        $pages = explode("|",$request->pages);

        foreach($pages as $page){
            ArticleCategory::whereId($page)->update(['user_id' => auth()->user()->id ]);
            ArticleCategory::whereId($page)->delete();
        }

        return back()->with('success', __('standard.news.category.delete_success'));
    }

    public function restore($id){
        ArticleCategory::withTrashed()->find($id)->update(['user_id' => auth()->user()->id ]);
        ArticleCategory::whereId($id)->restore();

        return back()->with('success', __('standard.news.category.restore_success'));

    }

    public function get_slug(Request $request)
    {
        return ModelHelper::convert_to_slug(ArticleCategory::class, $request->url);
    }
}
