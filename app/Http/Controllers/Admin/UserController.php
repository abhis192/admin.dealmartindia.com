<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserBank;
use App\Models\UserUpi;
use App\Models\UserMapping;
use App\Models\Pincode;
use App\Models\Product;
use App\Models\Type;
use App\Models\Tags;
use App\Models\Category;
use App\Models\ConfigKitchenPrice;
use App\Models\KitchenPrice;
use Carbon\carbon;
use Hash;
use Auth;
use DB;

class UserController extends Controller
{
    public function profileIndex()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function index()
    {
        $customers = User::whereRoleId(3)->whereNull('deleted_at')->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.customer.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email',
            'mobile' => 'required|numeric|digits:10',
            'dob'=> 'nullable|date_format:Y-m-d|before:today',
            'gender'=> 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'=>'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();
        if (isset($data['email_verified_at'])) {
           if ($data['email_verified_at'] == 'on') {
                $data['email_verified_at'] = Carbon::now();
            }
        } else{
            $data['email_verified_at'] = null;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);
        return redirect('/admin/customers')->with('success', 'User has been successfully updated.');
    }

    public function profileUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email',
            'mobile' => 'required|numeric|digits:10',
            'dob'=> 'nullable|date_format:Y-m-d|before:today',
            'gender'=> 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'=>'nullable|string|min:8|confirmed',
            'gst_name'=>'nullable|string',
            'gst_no'=>'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();
        $data['email_verified_at'] = Carbon::now();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);
        return redirect('/admin/profile')->with('success', 'Your profile updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->update(['deleted_at'=>Carbon::now(),'email_verified_at'=>null]);
    }

    // Active
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->update(['email_verified_at'=>Carbon::now()]);
        return redirect()->back()->with('success', 'User has been successfully activated.');
    }

    // Deactivate
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->update(['email_verified_at'=>null]);
        return redirect()->back()->with('success', 'User has been successfully deactivated.');
    }

    public function verifiedSellerIndex()
    {
        $sellers = User::whereRoleId(2)->whereNotNull('email_verified_at')->whereNull('deleted_at')->get();
        return view('admin.seller.verified.index', compact('sellers'));
    }

    public function verifiedSellerShow($id)
    {
        $user = User::findOrFail($id);
        return view('admin.seller.verified.show', compact('user'));
    }

    public function verifiedSellerEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.seller.verified.edit', compact('user'));
    }

    public function verifiedSellerUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email',
            'mobile' => 'required|numeric|digits:10',
            'dob'=> 'nullable|date_format:Y-m-d|before:today',
            'gender'=> 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'=>'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();
        if (isset($data['email_verified_at'])) {
           if ($data['email_verified_at'] == 'on') {
                $data['email_verified_at'] = Carbon::now();
            }
        } else{
            $data['email_verified_at'] = null;
        }

        if (isset($data['seller_verified_at'])) {
           if ($data['seller_verified_at'] == 'on') {
                $data['seller_verified_at'] = Carbon::now();
            }
        } else{
            $data['seller_verified_at'] = null;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);
        return redirect('/admin/verified-sellers')->with('success', 'User has been successfully updated.');
    }


    // Un Verified Sellers ==================================================================================

    public function unverifiedSellerIndex()
    {
        $sellers = User::whereRoleId(2)->whereNull('email_verified_at')->whereNull('deleted_at')->get();
        return view('admin.seller.unverified.index', compact('sellers'));
    }

    public function unverifiedSellerShow($id)
    {
        $user = User::findOrFail($id);
        return view('admin.seller.unverified.show', compact('user'));
    }

    public function unverifiedSellerEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.seller.unverified.edit', compact('user'));
    }

    public function unverifiedSellerUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email',
            'mobile' => 'required|numeric|digits:10',
            'dob'=> 'nullable|date_format:Y-m-d|before:today',
            'gender'=> 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'=>'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();
        if (isset($data['email_verified_at'])) {
           if ($data['email_verified_at'] == 'on') {
                $data['email_verified_at'] = Carbon::now();
            }
        } else{
            $data['email_verified_at'] = null;
        }

        if (isset($data['seller_verified_at'])) {
           if ($data['seller_verified_at'] == 'on') {
                $data['seller_verified_at'] = Carbon::now();
            }
        } else{
            $data['seller_verified_at'] = null;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);
        return redirect('/admin/unverified-sellers')->with('success', 'User has been successfully updated.');
    }

    // All Sellers ====================================================================================================

    public function allSellerIndex()
    {
        $sellers = User::whereRoleId(2)->whereNull('deleted_at')->get();
        return view('admin.seller.index', compact('sellers'));
    }

    public function allSellerCreate()
    {
        $user = User::all();
        return view('admin.seller.create', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3',
                'email' => 'required|email|unique:users,email',
                // 'mobile' => 'required',
                // 'password' => 'required|string|min:6|confirmed'
            ]);
            $data = $request->all();
            if (isset($data['email_verified_at'])) {
                if ($data['email_verified_at'] == 'on') {
                     $data['email_verified_at'] = Carbon::now();
                 }
             } else{
                 $data['email_verified_at'] = null;
             }

             if (isset($data['seller_verified_at'])) {
                if ($data['seller_verified_at'] == 'on') {
                     $data['seller_verified_at'] = Carbon::now();
                 }
             } else{
                 $data['seller_verified_at'] = null;
             }


            $data['role_id'] = 2;
            $data['password'] = Hash::make($request->get('password'));

            User::create($data);

            return redirect('/admin/all-sellers')->with('success','Product created successfully.');
        } catch (Exception $e){
            dd($e->getMessage());
            return redirect()->back()->with('failure', $e->getMessage());
        }
    }


    public function allSellerEdit($id)
    {
        $user = User::findOrFail($id);
        $pincodes = Pincode::whereStatus(1)->get();
        return view('admin.seller.edit', compact('user','pincodes'));
    }

    public function allSellerShow($id)
    {
        $user = User::findOrFail($id);
        return view('admin.seller.show', compact('user'));
    }

    public function allSellerUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email',
            'mobile' => 'required|numeric|digits:10|unique:users,mobile,'.$id,
            'dob'=> 'nullable|date_format:Y-m-d|before:today',
            'gender'=> 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'=>'nullable|string|min:8|confirmed'
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();
        if (isset($data['email_verified_at'])) {
           if ($data['email_verified_at'] == 'on') {
                $data['email_verified_at'] = Carbon::now();
            }
        } else{
            $data['email_verified_at'] = null;
        }

        if (isset($data['seller_verified_at'])) {
           if ($data['seller_verified_at'] == 'on') {
                $data['seller_verified_at'] = Carbon::now();
            }
        } else{
            $data['seller_verified_at'] = null;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);
        return redirect(url()->previous())->with('success', 'Seller has been successfully updated.');
    }

    public function allSellerPassUpdate(Request $request, $id) {
        $request->validate([
            'password'=>'required|string|min:8|confirmed'
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user->update($data);
        return redirect(url()->previous())->with('success', 'Seller password has been successfully updated.');
    }

    public function bankUpdate(Request $request, $id)
    {
        $request->validate([
            'holders_name'=>'required|string',
            'account_no'=>'required|string',
            'bank_name'=>'required|string',
            'ifsc_code'=>'required|string',
            'branch_name'=>'required|string'
        ]);

        $userBank = UserBank::whereUserId($id)->first();
        $data = $request->all();
        $data['user_id'] = $id;

        if ($userBank) {
            $userBank->update($data);
        } else {
            UserBank::create($data);
        }
        return redirect(url()->previous())->with('success', 'Seller Bank details has been successfully updated.');
    }

    public function upiUpdate(Request $request, $id)
    {
        $request->validate([
            'upi_name'=>'required|string',
            'upi_id'=>'required|string'
        ]);

        $userUpi = UserUpi::whereUserId($id)->first();
        $data = $request->all();
        $data['user_id'] = $id;

        if ($userUpi) {
            $userUpi->update($data);
        } else {
            UserUpi::create($data);
        }
        return redirect(url()->previous())->with('success', 'Seller UPI details has been successfully updated.');
    }

    public function mappingUpdate(Request $request, $id)
    {
        $request->validate([
            'pincode_id'=>'required'
        ]);
        $user = User::findOrFail($id);
        $userMapping = UserMapping::whereUserId($id)->get();
        $user->usermappings->each->delete();
        if(!empty($request->pincode_id)) {
            foreach ($request->pincode_id as $key => $val) {
                $tagData['user_id'] = $id;
                $tagData['pincode_id'] = $val;
                $productTag = UserMapping::create($tagData);
                }
            }
        return redirect(url()->previous())->with('success', 'Kitchen Mapping details has been successfully updated.');
    }



    public function gstUpdate(Request $request, $id)
    {
        $request->validate([
            'gst_name'=>'nullable|string',
            'gst_no'=>'nullable|string'
        ]);

        $user = User::findOrFail($id);
        $data = $request->all();
        $user->update($data);
        return redirect(url()->previous())->with('success', 'Seller GST details has been successfully updated.');
    }

    public function staffIndex() {
        $excludedRoleIds = [1, 2, 3];
        $users = User::whereNotIn('role_id', $excludedRoleIds)->get();
        return view('admin.staff.index', compact('users'));
    }

    public function staffCreate() {
        $excludedRoleIds = [1, 2, 3];
        $roles = Role::whereNotIn('id', $excludedRoleIds)->get();
        return view('admin.staff.create', compact('roles'));
    }

    public function staffPermissionIndex() {
        $excludedRoleIds = [1, 2, 3];
        $roles = Role::whereNotIn('id', $excludedRoleIds)->get();
        return view('admin.staff-permission.index', compact('roles'));
    }

    public function staffPermissionCreate()
    {
        return view('admin.staff-permission.create');
    }

    public function staffPermissionStore(Request $request)
    {
        $request->validate([
            'name'=>'required|string|unique:roles,name'
        ]);
        $data = $request->all();

        $roleData['name'] = $request->get('name');
        $roleData['slug'] = preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $roleData['name']));
        $role = Role::create($roleData);
        DB::table('permission_role')->whereRoleId($role->id)->delete();

        foreach ($data as $key => $value) {
            if ($permission = Permission::whereSlug($key)->first()){
                DB::table('permission_role')->insert(['permission_id'=>$permission->id, 'role_id'=>$role->id]);
            }
        }
        return redirect('/admin/staff-permissions')->with('success','Role added successfully.');
    }

    public function staffPermissionEdit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.staff-permission.edit', compact('role'));
    }

    public function staffPermissionUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
        ]);
        $data = $request->all();
        $role = Role::findOrFail($id);
        $roleData['name'] = $request->get('name');
        $roleData['slug'] = preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $roleData['name']));
        $role->update($roleData);
        DB::table('permission_role')->whereRoleId($role->id)->delete();

        foreach ($data as $key => $value) {
            if ($permission = Permission::whereSlug($key)->first()){
                DB::table('permission_role')->insert(['permission_id'=>$permission->id, 'role_id'=>$role->id]);
            }
        }
        return redirect('/admin/staff-permissions')->with('success','Role updated successfully.');
    }

    public function staffPermissionDestroy($id)
    {
        $role = Role::findOrFail($id);
        foreach ($role->users as $user) {
            $user->update(['email_verified_at' => null]);
        }
        $role->delete();
        DB::table('permission_role')->whereRoleId($id)->delete();
    }

    public function staffStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:users,name',
            'email' => 'required|string|email|unique:users,email',
            'mobile' => 'required|numeric|digits:10| unique:users,mobile',
            'role_id' => 'required',
            'password'=>'required|string|min:8|confirmed'
        ]);
        $data = $request->all();
        if (isset($data['email_verified_at'])) {
           if ($data['email_verified_at'] == 'on') {
                $data['email_verified_at'] = Carbon::now();
            }
        } else{
            $data['email_verified_at'] = null;
        }
        $data['password'] = Hash::make($request->get('password'));
        User::create($data);
        return redirect('/admin/staffs')->with('success','An staff member has been created successfully.');
    }

    public function staffEdit($id)
    {
        $user = User::findOrFail($id);
        $excludedRoleIds = [1, 2, 3];
        $roles = Role::whereNotIn('id', $excludedRoleIds)->get();
        return view('admin.staff.edit', compact('user','roles'));
    }

    public function staffUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:users,name,' . $id,
            'email' => 'required|string|email|unique:users,email,' . $id,
            'mobile' => 'required|numeric|digits:10|unique:users,mobile,' . $id,
            'role_id' => 'required',
            'password'=> 'nullable|string|min:8|confirmed'
        ]);
        $data = $request->all();
        if (isset($data['email_verified_at'])) {
           if ($data['email_verified_at'] == 'on') {
                $data['email_verified_at'] = Carbon::now();
            }
        } else{
            $data['email_verified_at'] = null;
        }
        if (isset($data['password'])) {
            $data['password'] = Hash::make($request->get('password'));
        } else {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        User::findOrFail($id)->update($data);
        return redirect('/admin/staffs')->with('success','An staff member has been updated successfully.');
    }


}
