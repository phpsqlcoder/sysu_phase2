<?php

namespace App\Http\Controllers\Settings;
use App\Helpers\ListingHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Role;

class RoleController extends Controller
{
    private $searchFields = ['name'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('checkPermission:admin/role', ['only' => ['index']]);
        $this->middleware('checkPermission:admin/role/create', ['only' => ['create','store']]);
        $this->middleware('checkPermission:admin/role/edit', ['only' => ['show','edit','update']]);
        $this->middleware('checkPermission:admin/role/delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $customConditions = [
            [
                'field' => 'id',
                'operator' => '>',
                'value' => 1,
                'apply_to_deleted_data' => true
            ]
        ];

        $listing = new ListingHelper('desc', 10, 'updated_at', $customConditions);

        $roles = $listing->simple_search(Role::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);

        $searchType = 'simple_search';

        return view('admin.settings.role.index', compact('roles','filter', 'searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Role::where('name',$request->role)->exists()){
            return back()->with('duplicate', __('standard.account_management.roles.duplicate_role'));
        } else {
            Role::create([
                'name' 		  => $request->role,
                'description' => $request->description,
                'created_by'  => Auth::user()->id
            ]);
            return redirect()->route('role.index')->with('success', __('standard.account_management.roles.create_success'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::where('id',$id)->first();

        return view('admin.settings.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Role::find($id)->update([
            'name'        => $request->role,
            'description' => $request->description,
            'created_by'  => Auth::user()->id
        ]);

        return redirect()->route('role.index')->with('success', __('standard.account_management.roles.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->role_id != 1) {
            Role::find($request->role_id)->delete();
        }

        return back()->with('success',  __('standard.account_management.roles.delete_success'));
    }

    public function restore($id)
    {
        Role::withTrashed()->findOrFail($id)->restore();

        return back()->with('success', __('standard.account_management.roles.restore_success'));
    }
}
