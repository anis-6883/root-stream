<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $app_unique_id = '')
    {
        if(Auth::user()->can('user.view'))
        {
            if($request->get('id'))
            $app_unique_id = $request->id;

            $users = [];
            if($app_unique_id != ''){
                $app = AppModel::where('app_unique_id', $app_unique_id)->first();
                $users = User::where('app_id', $app->id)->get();
            }


            if ($request->ajax()) {
                return DataTables::of($users)
                ->addColumn('image', function ($user) {
                    if($user->image){
                        return '<div style=" white-space: nowrap; ">
                        <img class="img-sm img-thumbnail" src="' . asset($user->image) . '">
                        </div>';
                    }
                    return '<div style=" white-space: nowrap; ">
                        <img class="img-sm img-thumbnail" src="' . asset('public/default/profile.png') . '">
                        </div>';
                })
                ->addColumn('name', function ($user) {
                    return $user->name;
                })
                ->addColumn('subscription', function ($user) {
                    $subscription = Subscription::find($user->subscription_id);
                    if($subscription){
                        return $subscription->name;
                    }
                    return "Free User";
                })
                ->addColumn('status', function($subscription){
                    if($subscription->status == 1){
                        return '<span class="badge rounded-pill border border-success text-success">Active</span>';
                    }else{
                        return '<span class="badge rounded-pill border border-danger text-danger">In-Active</span>';
                    }
                })
                ->addColumn('action', function($user) {
                    return '<div class="dropdown">
                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="' . route('users.edit', $user->id) . '" class="dropdown-item ajax-modal" data-title="Edit User">
                                            <i class="fas fa-edit"></i>
                                                Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="' . route('users.destroy', $user->id) . '" method="post" class="ajax-delete">'
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
                ->setRowData([
                    'id' => function($user) {
                        return $user->id;
                    }
                ])
                ->rawColumns(['action', 'status', 'subscription', 'name', 'image'])
                ->make(true);
            }

            return view('users.index', compact('users', 'app_unique_id'));
        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Auth::user()->can('user.create'))
        {
            if (!$request->ajax()) {
                return view('users.create');
            } else {
                return view('users.modal.create');
            }
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
        $app = AppModel::find($request->app_id);
        $request->merge(['email' => "{$app->id}_$request->email"]);
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'app_id' => 'required',
            'subscription_id' => 'required',
            'status' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|image',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->app_id = $request->app_id;
        $user->subscription_id = $request->subscription_id;
        $user->provider = 'email';
        $user->user_type = 'user';
        $user->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/users/'), $ImageName);
            $user->image = 'public/uploads/images/users/' . $ImageName;
        }

        $user->save();

        

        if (!$request->ajax()) {
            return redirect('users?id=' . $app->app_unique_id)->with('success', _lang('Information has been added.'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => 'users?id=' . $app->app_unique_id, 'message' => _lang('Information has been added sucessfully.')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(Auth::user()->can('user.edit'))
        {
            $user = User::find($id);

            if (!$request->ajax()) {
                return view('users.edit', compact('user'));
            } else {
                return view('users.modal.edit', compact('user'));
            }
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
        $app = AppModel::find($request->app_id);
        // $request->merge(['email' => "{$app->id}_$request->email"]);
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:191',
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'app_id' => 'required',
            'subscription_id' => 'required',
            'status' => 'required',
            'image' => 'nullable|image',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = 'user';
        $user->app_id = $request->app_id;
        $user->subscription_id = $request->subscription_id;
        $user->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ImageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/users/'), $ImageName);
            $user->image = 'public/uploads/images/users/' . $ImageName;
        }

        $user->save();

        if (!$request->ajax()) {
            return redirect('users?id=' . $app->app_unique_id)->with('success', _lang('Information has been updated!'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => 'users?id=' . $app->app_unique_id, 'message' => _lang('Information has been updated sucessfully.')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $image_path = $user->image;
    
        if($image_path != "public/default/profile.png")
        {
            if(File::exists($image_path))
                File::delete($image_path);
        }

        $user->delete();

        if (!$request->ajax()) {
            return back()->with('success', _lang('Information has been deleted'));
        } else {
            return response()->json(['result' => 'success', 'message' => _lang('Information has been deleted sucessfully')]);
        }
    }
}
