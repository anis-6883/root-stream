<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $app_unique_id = '')
    {
        if(Auth::user()->can('subscription.view')) 
        {
            $app_unique_id = $request->id;
            $subscriptions = [];

            if($app_unique_id != ''){
                $app = AppModel::where('app_unique_id', $app_unique_id)->first();
                $subscriptions = Subscription::where('app_id', $app->id)->orderBy('position')->get();
            }

            if ($request->ajax()) {
                return DataTables::of($subscriptions)
                    ->editColumn('platform', function ($subscription) {
                        return strtoupper($subscription->platform);
                    })
                    ->editColumn('duration', function ($subscription) {
                        return ucwords("{$subscription->duration} {$subscription->duration_type}");
                    })
                    ->addColumn('status', function($subscription){
                        if($subscription->status == 1){
                            return '<span class="badge rounded-pill border border-success text-success">Active</span>';
                        }else{
                            return '<span class="badge rounded-pill border border-danger text-danger">In-Active</span>';
                        }
                    })
                    ->addColumn('action', function($subscription) {
                        return '<div class="dropdown">
                                    <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="' . route('subscriptions.edit', $subscription->id) . '" class="dropdown-item">
                                                <i class="fas fa-edit"></i>
                                                    Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="' . route('subscriptions.destroy', $subscription->id) . '" method="post" class="ajax-delete">'
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
                        'id' => function($subscription) {
                            return $subscription->id;
                        }
                    ])
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }

            return view('subscriptions.index', compact('subscriptions', 'app_unique_id'));
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
        if(Auth::user()->can('subscription.view')) 
        {
            $apps = AppModel::where('status', 1)->get();
            return view('subscriptions.create', compact('apps'));
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

            'name' => 'required|string|max:191',
            'duration_type' => 'required|string',
            'duration' => 'required',
            'platform' => 'required',
            'product_id' => 'required',
            'app_id' => 'required',
            'status' => 'required',
            'description' => 'required',
            'description.*' => 'required',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $descriptions = [];
        foreach ($request->description as $key => $value) {
            if($value != null){
                $descriptions[] = [
                    'description' => $value,
                    'image' => null,
                ];
            }
        }

        $subscription = new Subscription();
        $subscription->name = $request->name;
        $subscription->description = json_encode($descriptions);
        $subscription->duration_type = $request->duration_type;
        $subscription->duration = $request->duration;
        $subscription->platform = $request->platform;
        $subscription->product_id = $request->product_id;
        $subscription->app_id = $request->app_id;
        $subscription->status = $request->status;

        $subscription->save();

        $app = AppModel::find($request->app_id);

        if (!$request->ajax()) {
            return redirect('subscriptions?id=' . $app->app_unique_id)->with('success', _lang('Information has been added.'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => url('subscriptions?id=' . $app->app_unique_id), 'message' => _lang('Information has been added sucessfully.')]);
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
        if(Auth::user()->can('subscription.edit')) 
        {
            $subscription = Subscription::find($id);
            $apps = AppModel::where('status', 1)->get();
            return view('subscriptions.edit', compact('subscription', 'apps'));
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

            'name' => 'required|string|max:191',
            'duration_type' => 'required|string',
            'duration' => 'required',
            'platform' => 'required',
            'product_id' => 'required',
            'app_id' => 'required',
            'status' => 'required',
            'description' => 'required',
            'description.*' => 'required',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        
        $descriptions = [];
        foreach ($request->description as $key => $value) {
            if($value != null){
                
                
                $descriptions[] = [
                    'description' => $value,
                    'image' => null,
                ];
            }
        }
    
        $subscription = Subscription::find($id);

        $subscription->name = $request->name;
        $subscription->description = json_encode($descriptions);
        $subscription->duration_type = $request->duration_type;
        $subscription->duration = $request->duration;
        $subscription->platform = $request->platform;
        $subscription->product_id = $request->product_id;
        $subscription->app_id = $request->app_id;
        $subscription->status = $request->status;

        $subscription->save();

        $app = AppModel::find($request->app_id);

        if (!$request->ajax()) {
            return redirect('subscriptions?id=' . $app->app_unique_id)->with('success', _lang('Information has updated added.'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => url('subscriptions?id=' . $app->app_unique_id), 'message' => _lang('Information has been updated sucessfully.')]);
        }
    }

    public function reorder(Request $request)
    {
        $subscriptions = json_decode($request->subscriptions);
        foreach ($subscriptions as $subscription_data) {
            $subscription = Subscription::find($subscription_data->id);
            $subscription->position = $subscription_data->position;
            $subscription->save();
        }
        
        if (!$request->ajax()) {
            return redirect('subscriptions')->with('success', _lang('Information has updated added.'));
        } else {
            return response()->json(['result' => 'success', 'message' => _lang('Information has been updated sucessfully.')]);
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
        if(Auth::user()->can('subscription.delete')) 
        {
            $subscription = Subscription::find($id);
            $subscription->delete();

            if (!$request->ajax()) {
                return back()->with('success', _lang('Information has been deleted'));
            } else {
                return response()->json(['result' => 'success', 'message' => _lang('Information has been deleted sucessfully')]);
            }
        }
        abort(403);
    }

    public function get_subscriptions(Request $request, $app_id = '')
    {
        $results = Subscription::where('app_id', $app_id)->orderBy('position', 'ASC')->get();
        
        $output = '';
        $output .= '<option value="">Select One</option>';
        $output .= '<option value="0">Free User</option>';
        foreach($results as $data){
            $output .= '<option value="' . $data->id . '">' . $data->name . '</option>';
        }
        return $output;
    }
}
