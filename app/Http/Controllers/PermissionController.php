<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('permission.view')) {

            $permissions = DB::table('permissions')->orderBy('id', 'DESC')->get();

            if($request->ajax()) {
                return DataTables::of($permissions)
                ->addColumn('created_at', function($permission) {
                    return date("M d, Y H:i:s", strtotime($permission->created_at));
                })
                ->addColumn('action', function($permission) {
                    return '<div class="dropdown">
                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="' . route('permissions.edit', $permission->id) . '" class="dropdown-item">
                                            <i class="fas fa-edit"></i>
                                                Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="' . route('permissions.destroy', $permission->id) . '" method="post" class="ajax-delete">'
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
            return view('permissions.index');
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
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
            'permission_name' => 'required|string|max:127|unique:permissions,name',
            'group_name' => 'required|string|max:127',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        Permission::create(['name' => $request->permission_name, 'group_name' => $request->group_name]);

        DB::commit();

        return back()->with('success', 'Information has been added!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = DB::table('permissions')->where('id', $id)->first();
        return view('permissions.edit', compact('permission'));
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
            'permission_name' => [
                'required',
                'string',
                'max:127',
                Rule::unique('permissions', 'name')->ignore($id),
            ],
            'group_name' => 'required|string|max:127',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        DB::table('permissions')->where('id', $id)->update(['name' => $request->permission_name, 'group_name' => $request->group_name]);

        DB::commit();

        return redirect('permissions')->with('success', 'Information has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::table('permissions')->where('id', $id)->delete();

        if (!$request->ajax()) {
            return back()->with('success', 'Information has been deleted!');
        } else {
            return response()->json(['result' => 'success', 'message' => 'Information has been deleted sucessfully']);
        }
    }
}
