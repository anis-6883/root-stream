<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AppController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        if(Auth::user()->can('app.view')) 
        {
            $apps = AppModel::orderBy('id', 'DESC');

            if ($request->ajax()) {
                return DataTables::of($apps)
                    ->addColumn('app_logo', function ($app) {
                        if($app->app_logo_type == 'url'){
                            return '<div style=" white-space: nowrap; ">
                            <img class="img-sm img-thumbnail" src="' . $app->app_logo_url . '">
                            </div>';
                        }
                        else{
                            return '<div style=" white-space: nowrap; ">
                            <img class="img-sm img-thumbnail" src="' . asset($app->app_logo) . '">
                            </div>';
                        }
                    })
                    ->addColumn('_app', function($app){

                        return 'ID: <a href="javascript:void(0);">' . $app->app_unique_id . '</a><br>Name: ' . $app->app_name;
                    })
                    ->addColumn('status', function ($app) {
                        if($app->status == 1){
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
                                            <a href="' . route('apps.edit', $admin->id) . '" class="dropdown-item">
                                                <i class="fas fa-edit"></i>
                                                    Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="' . route('apps.destroy', $admin->id) . '" method="post" class="ajax-delete">'
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
                    ->rawColumns(['action', 'app_logo', '_app', 'status'])
                    ->make(true);
            }
    
            return view('apps.index');
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
        if(Auth::user()->can('app.create')) 
        {
            return view('apps.create');
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
            
            'app_unique_id' => 'required|string|max:191',
            'app_name' => 'required|string|max:191',
            'app_logo_type' => 'required|string|max:20',
            'app_logo_url' => 'nullable|required_if:app_logo_type,url|url',
            'app_logo' => 'nullable|required_if:app_logo_type,image|image',
            'notification_type' => 'required|string|max:20',
            'onesignal_app_id' => 'nullable|required_if:notification_type,==,onesignal|string|max:191',
            'onesignal_api_key' => 'nullable|required_if:notification_type,==,onesignal|string|max:191',
            'firebase_server_key' => 'nullable|required_if:notification_type,==,fcm|string|max:191',
            'firebase_topics' => 'nullable|required_if:notification_type,==,fcm|string|max:191',
            'support_mail' => 'nullable|string|max:191',
            'from_mail' => 'nullable|string|max:191',
            'from_name' => 'nullable|string|max:191',
            'smtp_host' => 'nullable|string|max:191',
            'smtp_port' => 'nullable|string|max:191',
            'smtp_username' => 'nullable|string|max:191',
            'smtp_password' => 'nullable|string|max:191',
            'smtp_encryption' => 'nullable|string|max:191',
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }

        $app = new AppModel();
        
        $app->app_unique_id  = $request->app_unique_id ;
        $app->app_name = $request->app_name;
        $app->app_logo_type = $request->app_logo_type;
        $app->app_logo_url = $request->app_logo_url;
        $app->notification_type = $request->notification_type;
        $app->onesignal_app_id = $request->onesignal_app_id;
        $app->onesignal_api_key = $request->onesignal_api_key;
        $app->firebase_server_key = $request->firebase_server_key;
        $app->firebase_topics = $request->firebase_topics;
        $app->support_mail = $request->support_mail;
        $app->from_mail = $request->from_mail;
        $app->from_name = $request->from_name;
        $app->smtp_host = $request->smtp_host;
        $app->smtp_port = $request->smtp_port;
        $app->smtp_username = $request->smtp_username;
        $app->smtp_password = $request->smtp_password;
        $app->smtp_encryption = $request->smtp_encryption;
        $app->status = $request->status;
        
        if($request->hasFile('app_logo')){
            $file = $request->file('app_logo');
            $file_name = 'APP_' . rand() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/images/apps/'), $file_name);
            $app->app_logo = 'public/uploads/images/apps/' . $file_name;
        }
        
        $app->save();
		
		Cache::forget("app_" . $app->app_unique_id);

        if(! $request->ajax()){
            return redirect('/apps')->with('success', _lang('Information has been added sucessfully'));
        }else{
            return response()->json(['result' => 'success', 'redirect' => url('apps'), 'message' => _lang('Information has been added sucessfully!')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('app.edit')) 
        {
            $app = AppModel::find($id);
            return view('apps.edit', compact('app'));
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
            
            'app_name' => 'required|string|max:191',
            'app_logo_type' => 'required|string|max:20',
            'app_logo_url' => 'nullable|required_if:app_logo_type,url|url',
            'app_logo' => 'nullable|image',
            'notification_type' => 'required|string|max:20',
            'onesignal_app_id' => 'nullable|required_if:notification_type,==,onesignal|string|max:191',
            'onesignal_api_key' => 'nullable|required_if:notification_type,==,onesignal|string|max:191',
            'firebase_server_key' => 'nullable|required_if:notification_type,==,fcm|string|max:191',
            'firebase_topics' => 'nullable|required_if:notification_type,==,fcm|string|max:191',
            'support_mail' => 'nullable|string|max:191',
            'from_mail' => 'nullable|string|max:191',
            'from_name' => 'nullable|string|max:191',
            'smtp_host' => 'nullable|string|max:191',
            'smtp_port' => 'nullable|string|max:191',
            'smtp_username' => 'nullable|string|max:191',
            'smtp_password' => 'nullable|string|max:191',
            'smtp_encryption' => 'nullable|string|max:191',
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }

        $app = AppModel::find($id);
        
        $app->app_name = $request->app_name;
        $app->app_logo_type = $request->app_logo_type;
        $app->app_logo_url = $request->app_logo_url;
        $app->notification_type = $request->notification_type;
        $app->onesignal_app_id = $request->onesignal_app_id;
        $app->onesignal_api_key = $request->onesignal_api_key;
        $app->firebase_server_key = $request->firebase_server_key;
        $app->firebase_topics = $request->firebase_topics;
        $app->support_mail = $request->support_mail;
        $app->from_mail = $request->from_mail;
        $app->from_name = $request->from_name;
        $app->smtp_host = $request->smtp_host;
        $app->smtp_port = $request->smtp_port;
        $app->smtp_username = $request->smtp_username;
        $app->smtp_password = $request->smtp_password;
        $app->smtp_encryption = $request->smtp_encryption;
        $app->status = $request->status;

        $prevImageName = $app->app_logo;

        if($request->hasFile('app_logo')){
            $file = $request->file('app_logo');
            $file_name = 'APP_' . rand() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(base_path('public/uploads/images/apps/'), $file_name);
            $app->app_logo = 'public/uploads/images/apps/' . $file_name;

            if(File::exists($prevImageName))
                File::delete($prevImageName);
        }

        $app->save();
		
		Cache::forget("app_" . $app->app_unique_id);

        if(! $request->ajax()){
            return redirect('apps')->with('success', _lang('Information has been updated sucessfully'));
        }else{
            return response()->json(['result' => 'success', 'redirect' => url('apps'), 'message' => _lang('Information has been updated sucessfully!')]);
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
        if(Auth::user()->can('app.delete')) 
        {
            $app = AppModel::findOrFail($id);
            $image_path = $app->app_logo;
        
            if(File::exists($image_path))
                File::delete($image_path);
            
            Cache::forget("app_" . $app->app_unique_id);
            
            $app->delete();

            // AppContent::where('app_id', $id)->delete();

            if (!$request->ajax()) {
                return back()->with('success', _lang('Information has been deleted'));
            } else {
                return response()->json(['result' => 'success', 'message' => _lang('Information has been deleted sucessfully!')]);
            }
        }
        abort(403);
    }
}
