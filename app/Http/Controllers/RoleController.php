<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('role.view')) 
        {
            $roles = Role::all();

            if($request->ajax()) {
                return DataTables::of($roles)
                ->addColumn('created_at', function($role) {
                    return date("M d, Y H:i:s", strtotime($role->created_at));
                })
                ->addColumn('action', function($role) {
                    return '<div class="dropdown">
                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="' . route('roles.edit', $role->id) . '" class="dropdown-item">
                                            <i class="fas fa-edit"></i>
                                                Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="' . route('roles.destroy', $role->id) . '" method="post" class="ajax-delete">'
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
                ->rawColumns(['created_at', 'action'])
                ->make(true);
            }
            return view('roles.index');
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
        if(Auth::user()->can('role.create')) 
        {
            $all_permissions = DB::table('permissions')->get();
            $permission_groups = DB::table('permissions')->select('group_name')->distinct()->get();
            return view("roles.create", compact('permission_groups', 'all_permissions'));
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
            'role_name' => 'required|string|max:127|unique:roles,name',
            'permissions' => 'required',
            'permissions.*' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        $role = Role::create(['name' => $request->role_name]);

        for ($i=0; $i < count($request->permissions); $i++) 
        { 
            $role->givePermissionTo($request->permissions[$i]);
        }

        DB::commit();

        return redirect('roles')->with('success', 'Information has been added sucessfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('role.edit')) 
        {
            $role = Role::findById($id);
            $permission_groups = DB::table('permissions')->select('group_name')->distinct()->get();
            $all_permissions = DB::table('permissions')->get();
            return view("roles.edit", compact('role', 'permission_groups', 'all_permissions'));
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
            // 'role_name' => [
            //     'required',
            //     'string',
            //     'max:127',
            //     Rule::unique('roles', 'name')->ignore($id),
            // ],
            'role_name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'required',
            'permissions.*' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        DB::table('roles')->where('id', $id)->update(['name' => $request->role_name]);

        $role = Role::findById($id);

        if(!empty($request->permissions)){
            $role->syncPermissions($request->permissions);
        }

        DB::commit();

        return redirect('roles')->with('success', 'Information has been updated sucessfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(Auth::user()->can('role.delete')) 
        {
            $role = Role::findById($id);
            if(!is_null($role)){
                $role->delete();
            }
    
            if (!$request->ajax()) {
                return back()->with('success', 'Information has been deleted!');
            } else {
                return response()->json(['result' => 'success', 'message' => 'Information has been deleted sucessfully']);
            }
        }
        abort(403);
    }
}
