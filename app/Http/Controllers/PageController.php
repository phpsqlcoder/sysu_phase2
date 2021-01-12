<?php

namespace App\Http\Controllers;

use App\Helpers\ListingHelper;
use App\Helpers\Webfocus\Setting;
use App\Permission;
use App\User;
use App\Menu;
use App\Page;
use App\Album;
use App\Article;
use App\Category;
use Response;
use Auth;
use Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PagePost;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{

    private $searchFields = ['name'];
    private $advanceSearchFields = ['album_id', 'name', 'label', 'contents', 'status', 'meta_title', 'meta_keyword', 'meta_description', 'user_id', 'updated_at1', 'updated_at2'];

    public function __construct()
    {
        Permission::module_init($this, 'page');

//        $this->middleware('checkPermission:admin/page', ['only' => ['index']]);
//        $this->middleware('checkPermission:admin/page/create', ['only' => ['create','store']]);
//        $this->middleware('checkPermission:admin/page/edit', ['only' => ['show','edit','update']]);
    }

    public function index(Request $request)
    {
        $listing = new ListingHelper();

        $pages = $listing->simple_search(Page::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);

        // Advance search init data
        $advanceSearchData = $listing->get_search_data($this->advanceSearchFields);
        $uniquePagesByAlbum = $listing->get_unique_item_by_column(Page::class, 'album_id');
        $uniquePagesByUser = $listing->get_unique_item_by_column(Page::class, 'user_id');

        $searchType = 'simple_search';

        return view('admin.pages.index',compact('pages', 'filter', 'advanceSearchData', 'uniquePagesByAlbum', 'uniquePagesByUser', 'searchType'));

    }

    public function advance_index(Request $request)
    {
        $equalQueryFields = ['album_id', 'status', 'user_id'];

        $listing = new ListingHelper();
        $pages = $listing->advance_search(Page::class, $this->advanceSearchFields, $equalQueryFields);

        $filter = $listing->get_filter($this->searchFields);

        $advanceSearchData = $listing->get_search_data($this->advanceSearchFields);
        $uniquePagesByParent = $listing->get_unique_item_by_column(Page::class, 'parent_id');
        $uniquePagesByAlbum = $listing->get_unique_item_by_column(Page::class, 'album_id');
        $uniquePagesByUser = $listing->get_unique_item_by_column(Page::class, 'parent_page_id');

        $searchType = 'advance_search';

        return view('admin.pages.index', compact('pages','filter', 'advanceSearchData', 'uniquePagesByParent', 'uniquePagesByAlbum', 'uniquePagesByUser', 'searchType'));
    }

    public function create()
    {
        $albums = Album::where('type', 'sub_banner')->get();
        $pages = Page::where('page_type', '!=', 'uneditable')->get();

        return view('admin.pages.create', compact('albums', 'pages'));
    }


    public function store(PagePost $request)
    {
        $parentPageId = $this->check_parent_page_if_exist($request->parent_page);
        $slugArr = ['slug' => Page::convert_to_slug($request->page_title, $parentPageId)];

        Validator::make($slugArr, [
            'slug'            =>  'required|unique:pages,slug',
        ])->validate();

        /** Handles the banner of the page **/
        $album_id = '0';
        $image_url = '';
        if ($request->banner_type == 'banner_slider') {
            $album_id = $request->page_banner;
            $image_url = '';
        }

        if ($request->banner_type == 'banner_image') {
            $album_id = '0';

            if ($request->hasFile('page_image')) {
                $image_url = $this->upload_file_to_storage('banners', $request->file('page_image'), 'url');
            }
        }

        /** End of Banner Handling **/

        $slug = Page::convert_to_slug($request->page_title, $parentPageId);

        $page = Page::create([
            'album_id' => $album_id,
            'slug' => $slug,
            'parent_page_id' => $parentPageId,
            'name' => $request->page_title,
            'label' => $request->label,
            'contents' => $request->content,
            'status' => (isset($request->visibility) ? 'PUBLISHED' : 'PRIVATE'),
            'page_type' => 'standard',
            'image_url' => $image_url,
            'meta_title' => $request->seo_title,
            'meta_keyword' => $request->seo_keywords,
            'meta_description' => $request->seo_description,
            'user_id' => Auth::id(),
        ]);

//        if ($this->login_user_is_a_contributor()) {
//            $approvers  = User::where('role_id', 2)->get();
//
//            foreach ($approvers as $approver) {
//                \Mail::to($approver->email)->send(new ContributorAddPage(Setting::info(), $approver));
//            }
//        }

        return redirect()->route('pages.index')->with('success', __('standard.pages.create_success'));
    }

    public function create_new_file_name($oldFileName)
    {
        $fileNames = explode(".", $oldFileName);
        $count = 2;
        $newFilename = $fileNames[0] . ' (' . $count . ').' . $fileNames[1];
        while (Storage::disk('public')->exists($newFilename)) {
            $count += 1;
            $newFilename = $fileNames[0] . ' (' . $count . ').' . $fileNames[1];
        }

        return $newFilename;
    }

    public function edit(Page $page)
    {
        $albums = Album::where('type', 'sub_banner')->get();
        $parentPages = Page::where('id', '!=', $page->id)->where('page_type', '!=', 'uneditable')->get();
        $pageAlbum = $page->album;

        if ($page->is_customize_page()) {
            return view('admin.pages.customize', compact('page', 'parentPages', 'albums', 'pageAlbum'));
        } else {
            return view('admin.pages.edit', compact('page', 'parentPages', 'albums', 'pageAlbum'));
        }
    }


    public function update(PagePost $request, Page $page)
    {
        $parentPageId = $this->check_parent_page_if_exist($request->parent_page);
        $slugArr = ['slug' => Page::convert_to_slug($request->page_title, $parentPageId)];

        Validator::make($slugArr, [
            'slug'            =>  'required|unique:pages,slug',
        ])->validate();

        /** Handles the banner of the page **/
        $album_id = '0';
        $image_url = '';
        if ($request->banner_type == 'banner_slider') {
            $album_id = $request->page_banner;
            Storage::disk('public')->delete($page->get_image_url_storage_path());
        }

        if (isset($request->delete_image)) {
            Storage::disk('public')->delete($page->get_image_url_storage_path());
        } else {
            if ($request->banner_type == 'banner_image') {
                $album_id = '0';
                if ($request->hasFile('page_image')) {
                    $image_url = $this->upload_file_to_storage('banners', $request->file('page_image'), 'url');
                    Storage::disk('public')->delete($page->get_image_url_storage_path());
                } else {
                    $image_url = $page->image_url;
                }
            }
        }


        /** End of Banner Handling **/

        if ($page->page_type == "default") {
            if ($page->slug == "home") {
                $album_id = 1;
                $image_url = '';
            }

            $page->update([
                'label' => $request->label,
                'album_id' => $album_id,
                'contents' => $request->content,
                'image_url' => $image_url,
                'meta_title' => $request->seo_title,
                'meta_keyword' => $request->seo_keywords,
                'meta_description' => $request->seo_description,
                'user_id' => Auth::id(),
            ]);
        } else {
            $old_page = Page::whereId($page->id)->first();
            if ($page->name == $request->page_title && $page->parent_page_id == $parentPageId) {
                $slug = $old_page->slug;
            } else {
                $slug = Page::convert_to_slug($request->page_title, $parentPageId);
            }

            $page->update([
                'label' => $request->label,
                'album_id' => $album_id,
                'slug' => $slug,
                'parent_page_id' => $parentPageId,
                'name' => $request->page_title,
                'contents' => $request->content,
                'status' => (isset($request->visibility) ? 'PUBLISHED' : 'PRIVATE'),
                'image_url' => $image_url,
                'meta_title' => $request->seo_title,
                'meta_keyword' => $request->seo_keywords,
                'meta_description' => $request->seo_description,
                'user_id' => Auth::id(),
            ]);
        }

        return back()->with('success',  __('standard.pages.update_success'));
    }

    public function update_customize(Request $request, Page $page)
    {
        $updateData = $request->validate([
            'page_title' => 'required|max:150',
            'label' => 'required|max:150',
            'parent_page' => 'nullable|exists:page,id',
            'page_banner' => 'nullable',
            'visibility' => '',
            'seo_title' => 'max:60',
            'seo_description' => 'max:160',
            'seo_keywords' => 'max:160',
        ]);

        /** Handles the banner of the page **/
        $album_id = '0';
        $image_url = '';
        if ($request->banner_type == 'banner_slider') {
            $album_id = $request->page_banner;
            Storage::disk('public')->delete($page->get_image_url_storage_path());
        }

        if (isset($request->delete_image)) {
            Storage::disk('public')->delete($page->get_image_url_storage_path());
        } else {
            if ($request->banner_type == 'banner_image') {
                $album_id = '0';
                if ($request->hasFile('page_image')) {
                    $image_url = $this->upload_file_to_storage('banners', $request->file('page_image'), 'url');
                    Storage::disk('public')->delete($page->get_image_url_storage_path());
                } else {
                    $image_url = $page->image_url;
                }
            }
        }

        $old_page = Page::whereId($page->id)->first();
        $parentPageId = $this->check_parent_page_if_exist($request->parent_page);
        if ($page->name == $request->page_title && $page->parent_page_id == $parentPageId) {
            $slug = $old_page->slug;
        } else {
            $slug = Page::convert_to_slug($request->page_title, $parentPageId);
        }

        $updateData['status'] = (isset($request->visibility) ? 'PUBLISHED' : 'PRIVATE');
        $updateData['image_url'] = $image_url;
        $updateData['slug'] = $slug;
        $updateData['album_id'] = $album_id;
        $updateData['user_id'] = auth()->id();

        $page->update($updateData);

        return back()->with('success',  __('standard.pages.update_success'));
    }

    public function destroy(Page $page)
    {
        if ($this->is_deletable($page) && $page->delete()) {
            return back()->with('success', __('standard.pages.delete_success'));
        } else {
            return back()->with('error', __('standard.pages.delete_failed'));
        }
    }

    public function show($id)
    {

    }

    public function get_slug(Request $request)
    {
        return Page::convert_to_slug($request->url, $request->parentPage);
    }

    public function check_if_slug_exists_on_update($url, $id)
    {
        $slug = Str::slug($url, '-');

        if (Page::where('slug', '=', $slug)->where('id', '<>', $id)->exists()) {
            return true;
        } elseif (Article::where('slug', '=', $slug)->exists()) {
            return true;
        } elseif (Category::where('slug', '=', $slug)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    public function view($slug)
    {
        $page = Page::where('slug', $slug)->first();
        $menu = Menu::where('is_active', 1)->first();
        $settings = Setting::info();

        $breadcrumb = $this->breadcrumb($page);


        return view('theme.'.env('FRONTEND_TEMPLATE').'.main', compact('page', 'breadcrumb', 'menu', 'settings'));
    }

    public function breadcrumb($page)
    {
        return [
            'home' => '/home',
            $page->name => '/page/'.$page->slug
        ];
    }

    public function search()
    {
        $params = Input::all();

        return $this->index($params);
    }

    public function change_status(Request $request)
    {
        $pages = explode("|", $request->pages);

        foreach ($pages as $page) {
            $publish = Page::where('status', '!=', $request->status)
            ->whereId($page)
            ->update([
                'status'  => $request->status,
                'user_id' => Auth::user()->id
            ]);
        }

        return back()->with('success',  __('standard.pages.status_success',['STATUS' => $request->status]));
    }

    public function delete(Request $request)
    {
        $pages = explode("|", $request->pages);

        foreach ($pages as $pageId) {
            $page = Page::find($pageId);

            if ($page && $this->is_deletable($page)) {

                $page->update([ 'user_id' => Auth::user()->id ]);
                $page->delete();
            }
        }

        return back()->with('success', __('standard.pages.delete_success'));
    }

    public function is_deletable($page) {
        return $page->page_type == 'standard';
    }

    public function restore($page)
    {
        Page::withTrashed()->find($page)->update(['user_id' => Auth::id() ]);
        $restorePage = Page::whereId($page)->restore();

        return back()->with('success', __('standard.pages.restore_success'));
    }

    public function login_user_is_a_contributor()
    {
        return auth()->user()->role_id == 3;
    }

    public function upload_file_to_storage($folder, $file, $key = '')
    {
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

    public function check_parent_page_if_exist($parentPage)
    {
        return isset($parentPage) && $parentPage != null ? $parentPage : '0';
    }
}
