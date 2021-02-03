<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\ListingHelper;
use App\Http\Requests\UserRequest;
use App\Mail\AddNewUserMail;
use App\Permission;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Helpers\Webfocus\Setting;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

use App\Mail\UpdatePasswordMail;
use App\Role;
use App\User;
use App\Logs;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use SendsPasswordResetEmails;

    private $searchFields = ['name'];

    public function __construct()
    {
        Permission::module_init($this, 'customer');
    }

    public function index($param = null)
    {   
        $customConditions = [
            [
                'field' => 'is_active',
                'operator' => '=',
                'value' => 1,
                'apply_to_deleted_data' => false
            ],
            [
                'field' => 'role_id',
                'operator' => '=',
                'value' => 6,
                'apply_to_deleted_data' => true
            ]
        ];

        $listing = new ListingHelper('desc', 10, 'updated_at', $customConditions);

        $users = $listing->simple_search(User::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);

        $searchType = 'simple_search';

        return view('admin.customers.index',compact('users','filter', 'searchType'));
    }

    public function create()
    {
        $roles = Role::get();
        return view('admin.customers.create',compact('roles'));
    }

    public function store(Request $request)
    {
//        if(User::where('name',$request->fname.' '.$request->lname)->exists()){
//            return back()->with('duplicate', __('standard.users.duplicate_email'));
//        } else {
        $fname = '';
        if($request->is_org =='1')
        {
            $fname = explode("@",$request->email);
            $fname = $fname[0];
        }
        else
        {
            $fname = $request->fname;
        }
            $user = User::create([
                'firstname'             => $fname,
                'lastname'              => $request->lname,
                'name'                  => $fname.' '.$request->lname,
                'password'              => str_random(32),
                'email'                 => $request->email,
                'role_id'               => NULL,
                'is_active'             => 1,
                'user_id'               => NULL,
                'remember_token'        => str_random(10),
                'is_org'                => $request->is_org,
                'user_type'             => 'customer',
                'birthday'              => $request->birthday,
                'address_street'        => $request->address_street,
                'address_municipality'  => $request->address_municipality,
                'address_city'          => $request->address_city,
                'address_region'        => $request->address_region,
                'contact_person'        => $request->contact_person,
                'organization'          => $request->organization,
                'contact_tel'           => $request->contact_tel,
                'contact_mobile'        => $request->contact_mobile,
                'contact_fax'           => $request->contact_fax,
                'registration_source'   => $request->registration_source,
                'agent_code'            => $request->agent_code,
            ]);

            $user->send_reset_temporary_password_email();

            return redirect()->route('customers.index')->with('success', 'Pending for activation. Please remind the user to check the email and activate the account.');
//        }
    }

    public function edit($id)
    {
        $customer_type='';

        $roles = Role::get();
        $user = User::where('id',$id)->first();

        $collection= collect($user)->only([
           'id'
          ,'is_org'
        ]);

        if($collection['is_org']=='0')
        {
            $customer_type='Individual';
        }
        else
        {
            $customer_type='Organization';
        }

        return view('admin.customers.edit',compact('user','roles','collection','customer_type'));
    }

    public function update(Request $request, User $customer)
    {
       $fname = '';
        if($request->is_org =='1')
        {
            $fname = explode("@",$request->email);
            $fname = $fname[0];
        }
        else
        {
            $fname = $request->fname;
        }

       $customer->update([
            'firstname'             => $fname,
            'lastname'              => $request->lname,
            'name'                  => $fname.' '.$request->lname,
            'email'                 => $request->email,
            'is_org'                => $request->is_org,
            'user_type'             => 'customer',
            'birthday'              => $request->birthday,
            'address_street'        => $request->address_street,
            'address_municipality'  => $request->address_municipality,
            'address_city'          => $request->address_city,
            'address_region'        => $request->address_region,
            'contact_person'        => $request->contact_person,
            'organization'          => $request->organization,
            'contact_tel'           => $request->contact_tel,
            'contact_mobile'        => $request->contact_mobile,
            'contact_fax'           => $request->contact_fax,
            'registration_source'   => $request->registration_source,
            'agent_code'            => $request->agent_code,

        ]);

        return back()->with('success', 'The Customer details has been updated.');
    }

    public function deactivate(Request $request)
    {
    	User::find($request->user_id)->update([
            'is_active' => 0,
            'user_id'   => Auth::id(),
        ]);

        return back()->with('success', __('standard.customers.status_success', ['status' => 'deactivated']));
    }

    public function activate(Request $request)
    {
    	User::find($request->user_id)->update([
            'is_active' => 1,
            'user_id'   => Auth::id(),
        ]);

        return back()->with('success', __('standard.customers.status_success', ['status' => 'activated']));
    }


    public function show($id, $param = null)
    {
        $user = User::where('id',$id)->first();
        $logs = Logs::where('created_by',$id)->orderBy('id','desc')->paginate(10);

        return view('admin.customers.profile',compact('user','logs','param'));
    }

    public function filter()
    {
        $params = Input::all();

        return $this->apply_filter($params);
    }

    public function apply_filter($param = null)
    {
        $user = User::where('id',$param['id'])->first();

        if(isset($param['order'])){
            $logs = Logs::where('created_by',$param['id'])->orderBy($param['sort'],$param['order'])->paginate($param['pageLimit']);
        } else {
            $logs = Logs::where('created_by',$param['id'])->paginate($param['pageLimit']);
        }

        return view('admin.customers.profile',compact('user','logs','param'));
    }

}
