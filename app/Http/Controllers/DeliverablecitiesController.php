<?php

namespace App\Http\Controllers;

use App\Deliverablecities;
use App\Permission;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\ListingHelper;

class DeliverablecitiesController extends Controller
{
    private $searchFields = ['name'];

    public function __construct()
    {
        Permission::module_init($this, 'delivery_flat_rate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($param = null)
    {
        $listing = new ListingHelper('desc', 10, 'updated_at');

        $address = $listing->simple_search(Deliverablecities::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.deliverablelocations.index',compact('address', 'filter', 'searchType'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.deliverablelocations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save = Deliverablecities::create([
            'name' => $request->name,
            'rate' => $request->rate,
            'user_id' => Auth::id()
        ]);

        return redirect(route('locations.index'))->with('success','The location has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deliverablecities  $deliverablecities
     * @return \Illuminate\Http\Response
     */
    public function show(Deliverablecities $deliverablecities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deliverablecities  $deliverablecities
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rate = Deliverablecities::findOrFail($id);
        return view('admin.deliverablelocations.edit',compact('rate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deliverablecities  $deliverablecities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $save = Deliverablecities::findOrFail($id)->update([
            'name' => $request->name,
            'rate' => $request->rate,
            'user_id' => Auth::id()
        ]);

        return redirect(route('locations.index'))->with('success', __('standard.locations.update_details_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deliverablecities  $deliverablecities
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

    }

    public function update_status($id,$status)
    {
        Deliverablecities::find($id)->update([
            'status' => $status,
            'user_id' => Auth::id()
        ]);

        return back()->with('success', __('standard.locations.status_update_success', ['STATUS' => $status]));
    }

    public function single_delete(Request $request)
    {
        $promo = Deliverablecities::findOrFail($request->rates);
        $promo->update([ 'user' => Auth::id() ]);
        $promo->delete();

        return back()->with('success', __('standard.locations.single_delete_success'));

    }

    public function delete(Request $request)
    {
        $delete = Deliverablecities::whereId($request->delete_id)->delete();
        return back()->with('success','The location has been deleted.');
    }

    public function multiple_change_status(Request $request)
    {
        $rates = explode("|", $request->rates);

        foreach ($rates as $rate) {
            $publish = Deliverablecities::where('status', '!=', $request->status)->whereId($rate)->update([
                'status'  => $request->status,
                'user_id' => Auth::id()
            ]);
        }

        return back()->with('success',  __('standard.locations.multiple_status_update_success', ['STATUS' => $request->status]));
    }

    public function multiple_delete(Request $request)
    {
        $rates = explode("|",$request->rates);

        foreach($rates as $rate){
            Deliverablecities::whereId($rate)->update(['user_id' => Auth::id() ]);
            Deliverablecities::whereId($rate)->delete();
        }

        return back()->with('success', __('standard.locations.multiple_delete_success'));
    }
}
