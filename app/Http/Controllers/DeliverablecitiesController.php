<?php

namespace App\Http\Controllers;

use App\Deliverablecities;
use App\Permission;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliverablecitiesController extends Controller
{

    public function __construct()
    {
        Permission::module_init($this, 'delivery_flat_rate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $address = Deliverablecities::all();
        return view('admin.deliverablelocations.index',compact('address'));
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

        return back()->with('success','Successfully saved new location!');
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

        return back()->with('success','Successfully updated delivery rate!');
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
    public function delete(Request $request)
    {
        $delete = Deliverablecities::whereId($request->delete_id)->delete();
        return back()->with('success','Successfully deleted location.');
    }

    public function enable(Request $request)
    {
        $enable = Deliverablecities::whereId($request->enable_id)->update(['status' => 'PUBLISHED']);
        return back()->with('success','Successfully enabled location.');
    }
    public function disable(Request $request)
    {
        $disable = Deliverablecities::whereId($request->disable_id)->update(['status' => 'PRIVATE']);
        return back()->with('success','Successfully disabled location.');
    }
}
