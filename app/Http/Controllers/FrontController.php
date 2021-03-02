<?php

namespace App\Http\Controllers;

use App\Helpers\ListingHelper;
use App\Helpers\Webfocus\Setting;
use App\Http\Requests\ContactUsRequest;
use App\Mail\InquiryAdminMail;
use App\Mail\InquiryMail;
use App\Page;
use App\User;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Article;

class FrontController extends Controller
{

    public function home()
    {
        return $this->page('home');
        // return $this->page('home')->withShortcodes();
    }

    public function privacy_policy(){

        $footer = Page::where('slug', 'footer')->where('name', 'footer')->first();

        $page = new Page();
        $page->name = 'Privacy Policy';

        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.privacy-policy', compact('page', 'footer'));

    }

    public function search(Request $request)
    {
        $searchFields = ['name', 'label', 'contents'];
        $listing = new ListingHelper();

        $searchPages = $listing->simple_search(Page::class, $searchFields);

        $filter = $listing->get_filter($searchFields);

        $page = new Page();
        $page->name = 'Search';

        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.search', compact('searchPages', 'filter', 'page'));
    }

    public function page($slug)
    {
        if (Auth::guest()) {
            $page = Page::where('slug', $slug)->where('status', 'PUBLISHED')->first();
        } else {
            $page = Page::where('slug', $slug)->first();
        }

        if ($page == null) {
            $view404 = 'theme.'.env('FRONTEND_TEMPLATE').'.pages.404';
            if (view()->exists($view404)) {
                $page = new Page();
                $page->name = 'Page not found';
                return view($view404, compact('page'));
            }

            abort(404);
        }

        $breadcrumb = $this->breadcrumb($page);

        $footer = Page::where('slug', 'footer')->where('name', 'footer')->first();

        if (!empty($page->template)) {
            return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.'.$page->template, compact('footer', 'page', 'breadcrumb'));
        }

        $parentPage = null;
        $parentPageName = $page->name;
        $currentPageItems = [];
        $currentPageItems[] = $page->id;
        if ($page->has_parent_page() || $page->has_sub_pages()) {
            if ($page->has_parent_page()) {
                $parentPage = $page->parent_page;
                $parentPageName = $parentPage->name;
                $currentPageItems[] = $parentPage->id;
                while ($parentPage->has_parent_page()) {
                    $parentPage = $parentPage->parent_page;
                    $currentPageItems[] = $parentPage->id;
                }
            } else {
                $parentPage = $page;
                $currentPageItems[] = $parentPage->id;
            }
        }

        return view('theme.'.env('FRONTEND_TEMPLATE').'.page', compact('footer', 'page', 'parentPage', 'breadcrumb', 'currentPageItems', 'parentPageName'));
    }
    // public function page($slug)
    // {

    //     if(Auth::guest()) {
    //         $page = Page::where('slug', $slug)->where('status', 'PUBLISHED')->first();
    //     } else {
    //         $page = Page::where('slug', $slug)->first();
    //     }

    //     if($page == null) {
    //         abort(404);
    //     }

    //     $breadcrumb = $this->breadcrumb($page);

    //     $footer = Page::where('slug', 'footer')->where('name', 'footer')->first();

    //     if (!empty($page->template)) {
    //         return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.'.$page->template, compact('footer','page', 'breadcrumb'))->withShortcodes();
    //     }

    //     $parentPage = null;
    //     if ($page->has_parent_page() || $page->has_sub_pages())
    //     {
    //         if ($page->has_parent_page()) {
    //             $parentPage = $page->parent_page;
    //             while($parentPage->has_parent_page()) {
    //                 $parentPage = $parentPage->parent_page;
    //             }
    //         } else {
    //             $parentPage = $page;
    //         }
    //     }

    //     return view('theme.'.env('FRONTEND_TEMPLATE').'.page', compact('footer', 'page', 'parentPage','breadcrumb'))->withShortcodes();
    // }

    public function contact_us(ContactUsRequest $request)
    {
        $admins  = User::where('role_id', 1)->get();
        $client = $request->all();

        Mail::to($client['email'])->send(new InquiryMail(Setting::info(), $client));

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new InquiryAdminMail(Setting::info(), $client, $admin));
        }

        if (Mail::failures()) {
            return redirect()->back()->with('error','Failed to send inquiry. Please try again later.');
        }

        return redirect()->back()->with('success','Email sent!');
    }

    public function breadcrumb($page)
    {
        return [
            'Home' => url('/'),
            $page->name => url('/').'/'.$page->slug
        ];
    }
}
