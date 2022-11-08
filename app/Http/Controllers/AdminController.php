<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(Auth::user()->can('admin.view')) 
        {
            $admins = User::orderBy('id', 'DESC')->get();

            if($request->ajax()) {
                return DataTables::of($admins)
                ->addColumn('image', function($admin){
                    return '<img class="img-sm img-thumbnail" src="' . asset($admin->image) . '">';
                })
                ->addColumn('fullname', function($admin){
                    return $admin->full_name;
                })
                ->addColumn('role', function($admin){
                    return $admin->getRoleNames()->implode(', ');
                })
                ->addColumn('status', function($admin){
                    if($admin->status == 1){
                        return '<span class="badge rounded-pill border border-success text-success">Active</span>';
                    }else{
                        return '<span class="badge rounded-pill border border-danger text-danger">In-Active</span>';
                    }
                })
                ->addColumn('action', function($admin){
                    return '<div class="dropdown">
                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="' . route('admins.edit', $admin->id) . '" class="dropdown-item">
                                            <i class="fas fa-edit"></i>
                                                Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="' . route('admins.destroy', $admin->id) . '" method="post" class="ajax-delete">'
                                            . csrf_field() 
                                            . method_field('DELETE') 
                                            . '<button type="button" class="btn-remove dropdown-item">
                                                    <i class="fas fa-trash-alt"></i>
                                                        Delete
                                                </button>
                                        </form>
                                    </li>
                                </ul>
                        </div>';
                })
                ->rawColumns(['image', 'role', 'fullname', 'status', 'action'])
                ->make(true);
            }
            return view('admins.index');
        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('admin.create')) 
        {
            $roles = Role::all();
            return view("admins.create", compact('roles'));
        }
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'role_id.*' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'required|email|max:255|unique:users,email',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5048',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        $admin = new User();
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->status = $request->status;
        $admin->user_type = "staff";
        $admin->assignRole($request->role_id);
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = 'ADMIN_' . rand() . '.' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/admins/'), $ImageName);
            $admin->image = 'public/uploads/images/admins/' . $ImageName;
        }
        
        $admin->save();

        DB::commit();

        return redirect('admins')->with('success', 'Information has been added!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('admin.edit')) 
        {
            $admin = User::findOrFail($id);
            $roles = Role::all();
            return view("admins.edit", compact('admin', 'roles'));
        }
        abort(403);
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
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'role_id.*' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5048',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        $admin = User::findOrFail($id);
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->status = $request->status;
        $admin->syncRoles($request->role_id);

        $prevImageName = $admin->image;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = 'ADMIN_' .time() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/admins/'), $ImageName);
            $admin->image = 'public/uploads/images/admins/' . $ImageName;

            if($prevImageName != "public/default/profile.png")
            {
                if(File::exists($prevImageName))
                    File::delete($prevImageName);
            }
        }
        
        $admin->save();

        DB::commit();

        return redirect('admins')->with('success', 'Information has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can('admin.delete')) 
        {
            $admin = User::findOrFail($id);
            $image_path = $admin->image;
    
            if($image_path != "public/default/profile.png")
                if(File::exists($image_path))
                    File::delete($image_path);
    
            $admin->delete();
    
            if (!$request->ajax()) {
                return back()->with('success', 'Information has been deleted!');
            } else {
                return response()->json(['result' => 'success', 'message' => 'Information has been deleted sucessfully']);
            }
        }
        abort(403);
    }
}
