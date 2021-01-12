<?php

namespace App\Http\Controllers\EcommerceControllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\EcommerceModel\ProductReview;
use App\EcommerceModel\Product;
use App\Http\Controllers\Controller;
use App\Helpers\ListingHelper;
use Auth;

class ProductReviewController extends Controller
{
    public function index()
    {
        $orderDefault = ['id', 'status'];
        $orderDefault = 'created_at';

        $perPage = $this->get_count_per_page();
        $orderBy = $this->get_selected_order_by($orderDefault);
        $sortBy = $this->get_selected_sort_by();
        $showDeleted = $this->show_delete_data();
        $search = $this->get_search_string();

        $filter = [
            'perPage' => $perPage,
            'orderBy' => $orderBy,
            'sortBy' => $sortBy,
            'showDeleted' => $showDeleted,
            'search' => $search
        ];


        if ($showDeleted == 'on') {
            $reviews = ProductReview::withTrashed()->where('product_id', 'like', '%' . $search . '%')->orderBy($orderBy, $sortBy)->paginate($perPage);
        } else {
            $reviews = ProductReview::where('product_id', 'like', '%' . $search . '%')->orderBy($orderBy, $sortBy)->paginate($perPage);
        }

        if (isset($param['search_user'])) {
            $reviews->where('created_by', '=', $param['search_user']);
        }

        $all_reviews = ProductReview::withTrashed()->get();
       
        return view('admin.product-review.index', compact('reviews', 'perPage', 'orderBy', 'sortBy', 'filter', 'search', 'showDeleted', 'all_reviews'));

    }
    public function edit($id)
    {
        $reviews = ProductReview::findOrFail($id);

        return view('admin.product-review.index',compact('reviews'));
    }

    public function update(Request $request, $id)
    {
        $reviews = ProductReview::findOrFail($id);

        $reviews->update([
            'status' => $request->status,
            'updated_at' => auth()->user()->id
        ]);

        return back()->with('success', 'update success');
    }

    public function store(Request $request)
    {
        
        $product = ProductReview::create([
            'product_id' => $request->product_id,
            'review' => $request->review,
            'rating' => $request->rating,           
            'user_id' => Auth::id()           
        ]);
        return back();
        //return redirect()->route('products.index')->with('success', __('standard.products.product.create_success'));
    }

    public function restore($id){
        ProductReview::withTrashed()->find($id)->update(['created_by' => auth()->user()->id ]);
        ProductReview::whereId($id)->restore();

        return back()->with('success', 'The Review Request has been restored.');

    }

    public function change_status(Request $request)
    {
        $reviews = explode("|", $request->pages);

        foreach ($reviews as $reviews) {
            $publish = ProductReview::where('is_approved', '!=', 1)
            ->whereId($reviews)
            ->update([
                'is_approved'  => 1,
                'approver' => auth()->user()->id,
                'approved_date' => now()
            ]);
        }

        return back()->with('success',  __('The review status has been changed to Approved.'));

//        return 'dsds';
    }

    public function destroy(Request $request)
    {
        $review = ProductReview::findOrFail($request->id);
        $review->update([ 'created_by' => auth()->user()->id ]);
        $review->delete();

        return back()->with('success','The Product Review has been deleted');
    }

    public function delete(Request $request)
    {
        $reviews = explode("|", $request->pages);
        foreach ($reviews as $review) {
            $review = ProductReview::where('id', '=', $review)->delete();
        }

        return back()->with('success', 'The Product Review has been deleted.');
    }

    public function approve_review(Request $request)
    {
        $productReview = ProductReview::findOrFail($request->id);

        $mytime = Carbon::now();

        $productReview->update(['is_approved' => 1, 'approver' => auth()->id(), 'approved_date' => $mytime->toDateTimeString()]);

        return redirect()->back();
    }

//
    public function get_count_per_page($default = 10)
    {
        $perPage = request('perPage') && is_numeric(request('perPage')) ? request('perPage') : $default;
        return ($perPage > 100) ? 100 : $perPage;
    }

    public function get_selected_order_by($orderDefault = 'updated_at')
    {
        $orderBys = ['id', 'question', 'status'];
        return request('orderBy') && in_array(request('orderBy'), $orderBys) ? request('orderBy') : $orderDefault;
    }

    public function get_selected_sort_by($default = 'desc')
    {
        $sortBy = request('sortBy') ?? $default;
        return $sortBy == 'asc' ? 'asc' : 'desc';
    }

    public function get_search_string()
    {
        return request('search') ?? '';
    }

    public function show_delete_data()
    {
        return (request('showDeleted') && request('showDeleted') == 'on') ? 'on' : '';
    }
}
