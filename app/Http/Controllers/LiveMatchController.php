<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use App\Models\LiveMatch;
use App\Models\LiveMatchApp;
use App\Models\SportsType;
use App\Models\StreamingSource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LiveMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('live_match.view')) 
        {
            $live_matches = LiveMatch::orderBy('id', 'DESC');

            if ($request->ajax()) {
                return DataTables::of($live_matches)
                    ->addColumn('team_one', function ($live_match) {
                        if($live_match->team_one_image_type == 'url'){
                            return '<div style=" white-space: nowrap; ">
                            <img class="img-sm img-thumbnail" src="' . $live_match->team_one_url . '"><span class="ml-2">'
                            . $live_match->team_one_name .
                            '</span></div>';
                        }
                        if($live_match->team_one_image_type == 'image'){
                            return '<div style=" white-space: nowrap; ">
                            <img class="img-sm img-thumbnail" src="' . asset($live_match->team_one_image) . '"><span class="ml-2">'
                            . $live_match->team_one_name .
                            '</span></div>';
                        }
                        return '<div style=" white-space: nowrap; ">
                            <img class="img-sm img-thumbnail" src="' . asset('public/default/default-team.png') . '"><span class="ml-2">'
                            . $live_match->team_one_name .
                            '</span></div>';
                    })
                    ->addColumn('team_two', function ($live_match) {
                        if($live_match->team_two_image_type == 'url'){
                            return '<div style=" white-space: nowrap; ">
                            <img class="img-sm img-thumbnail" src="' . $live_match->team_two_url . '"><span class="ml-2">'
                            . $live_match->team_two_name .
                            '</span></div>';
                        }
                        if($live_match->team_two_image_type == 'image'){
                            return '<div style=" white-space: nowrap; ">
                            <img class="img-sm img-thumbnail" src="' . asset($live_match->team_two_image) . '"><span class="ml-2">'
                            . $live_match->team_two_name .
                            '</span></div>';
                        }
                        return '<div style=" white-space: nowrap; ">
                            <img class="img-sm img-thumbnail" src="' . asset('public/default/default-team.png') . '"><span class="ml-2">'
                            . $live_match->team_two_name .
                            '</span></div>';
                    })
                    ->addColumn('match_time', function ($live_match) {
                        return '<div>
                                    <div style="color: #0C32DE; margin-bottom: 5px; font-weight: bold;">'. $live_match->match_title .'</div>
                                    <div>'. $live_match->match_time3 .'</div>
                                </div>';
                    })
                    ->addColumn('apps', function ($live_match) {
                        $apps_name = '';
    
                        foreach (\App\Models\LiveMatchApp::where('match_id', $live_match->id)->join('apps', 'apps.id', 'app_id')->get() as $app){
                            $apps_name .= $app->app_name . ', ';
                        }
    
                        return $apps_name;
                    })
                    ->addColumn('action', function($admin){
                        return '<div class="dropdown">
                                    <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="' . route('live_matches.edit', $admin->id) . '" class="dropdown-item">
                                                <i class="fas fa-edit"></i>
                                                    Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="' . route('live_matches.destroy', $admin->id) . '" method="post" class="ajax-delete">'
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
                    ->rawColumns(['action', 'apps', 'team_one', 'team_two','match_time'])
                    ->make(true);
            }
    
            return view('live_matches.index');
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
        if(Auth::user()->can('live_match.create')) 
        {
            $apps = AppModel::where('status', 1)->get();
            $sports_types = SportsType::where('status', 1)->orderBy('id', 'DESC')->get();
            return view('live_matches.create', compact('apps', 'sports_types'));
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
        // dd($request->all());

        $validator = Validator::make($request->all(), [

            'apps' => 'required',
            'match_title' => 'required|string|max:191',
            'match_time' => 'required',
            'sports_type_id' => 'required',
            'team_one_name' => 'required|string|max:191',
            'team_one_image_type' => 'required|string|max:20',
            'team_one_url' => 'nullable|required_if:team_one_image_type,url|url',
            'team_one_image' => 'required_if:team_one_image_type,image|image',
            'team_two_name' => 'required|string|max:191',
            'team_two_image_type' => 'required|string|max:20',
            'team_two_url' => 'nullable|required_if:team_two_image_type,url|url',
            'team_two_image' => 'required_if:team_two_image_type,image|image',
			'cover_image_type' => 'required|string|max:20',
            'cover_url' => 'nullable|required_if:cover_image_type,url|url',
            'cover_image' => 'required_if:cover_image_type,image|image',
            'status' => 'required',

            'stream_title' => 'required',
            'stream_title.*' => 'required',
            'stream_type' => 'required',
            'stream_type.*' => 'required',
            'stream_url' => 'required',
            'stream_url.*' => 'required',
            'resulation' => 'required',
            'resulation.*' => 'required',
            'name' => 'nullable|required_if:stream_type,restricted',
            'name.*' => 'nullable|required_if:stream_type,restricted',
            'name.*.*' => 'nullable|required_if:stream_type,restricted',
            'value' => 'nullable|required_if:stream_type,restricted',
            'value.*' => 'nullable|required_if:stream_type,restricted',
            'value.*.*' => 'nullable|required_if:stream_type,restricted',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        DB::beginTransaction();

        $live_match = new LiveMatch();

        $live_match->sports_type_id = $request->sports_type_id;
        $live_match->match_title = $request->match_title;
        $live_match->match_time = Carbon::parse($request->match_time)->timestamp;
        $live_match->team_one_name = $request->team_one_name;
        $live_match->team_one_image_type = $request->team_one_image_type;
        $live_match->team_one_url = $request->team_one_url;
        $live_match->team_two_name = $request->team_two_name;
        $live_match->team_two_image_type = $request->team_two_image_type;
        $live_match->team_two_url = $request->team_two_url;
		$live_match->cover_image_type = $request->cover_image_type;
        $live_match->cover_url = $request->cover_url;
        $live_match->status = $request->status;
        
        if ($request->hasFile('team_one_image')) {
            $image = $request->file('team_one_image');
            $ImageName = 'TEAM_' . rand() . '.' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/live_matches/'), $ImageName);
            $live_match->team_one_image = 'public/uploads/images/live_matches/' . $ImageName;
        }

        if ($request->hasFile('team_two_image')) {
            $image = $request->file('team_two_image');
            $ImageName = 'TEAM_' . rand() . '.' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/live_matches/'), $ImageName);
            $live_match->team_two_image = 'public/uploads/images/live_matches/' . $ImageName;
        }
		
		if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $ImageName = 'COVER_' . rand() . '.' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/live_matches/'), $ImageName);
            $live_match->cover_image = 'public/uploads/images/live_matches/' . $ImageName;
        }

        $live_match->save();

        for ($i=0; $i < count($request->apps); $i++) { 
            
            $app = new LiveMatchApp();

            $app->app_id = $request->apps[$i];
            $app->match_id = $live_match->id;

            $app->save();
			
			$appData = AppModel::where('id', $app->app_id)->first();
			Cache::forget("live_matches_" . $appData->app_unique_id);
        }
		
	

        for ($i=0; $i < count($request->stream_title); $i++) { 
            if($request->stream_title[$i] != '' && $request->stream_type[$i] != '' && $request->stream_url[$i] != ''){

                $headers = '';

                if ($request->stream_type[$i] == 'restricted') {
                    $h = array();
                    if(isset($request->name[$i]) && isset($request->value[$i])){
                        for ($i2=0; $i2 < count($request->name[$i]); $i2++) { 
                            if($request->name[$i][$i2] != null && $request->value[$i][$i2] != null){
                                $h[$request->name[$i][$i2]] = $request->value[$i][$i2];
                            }
                        }
                    }
                    $headers = json_encode($h);
                }

                $streaming_source = new StreamingSource();

                $streaming_source->match_id = $live_match->id;
                $streaming_source->stream_title = $request->stream_title[$i];
                $streaming_source->resulation = $request->resulation[$i];
                $streaming_source->stream_type = $request->stream_type[$i];
                $streaming_source->stream_url = $request->stream_url[$i];
                $streaming_source->stream_key = $request->stream_type[$i] == 'root_stream' ? $request->stream_key[$i] : '';
                $streaming_source->headers = $request->stream_type[$i] == 'restricted' ? $headers : '';
                $streaming_source->block_country = $request->block_country[$i];
                $streaming_source->is_block_them = $request->is_block_them[$i] ?? 0;

                $streaming_source->save();
            }
        }

        DB::commit();
        
        Cache::forget("live_match_$live_match->id");
        Cache::forget("streamingSources_$live_match->id");

        if (!$request->ajax()) {
            return redirect('live_matches')->with('success', _lang('Information has been added.'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => url('live_matches'), 'message' => _lang('Information has been added sucessfully.')]);
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
        if(Auth::user()->can('live_match.edit')) 
        {
            $live_match = LiveMatch::findOrFail($id);
            $sports_types = SportsType::where('status', 1)->orderBy('id', 'DESC')->get();
            return view('live_matches.edit', compact('live_match', 'sports_types'));
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [

            'apps' => 'required',
            'match_title' => 'required|string|max:191',
            'match_time' => 'required',
            'sports_type_id' => 'required',
            'team_one_name' => 'required|string|max:191',
            'team_one_image_type' => 'required|string|max:20',
            'team_one_url' => 'nullable|required_if:team_one_image_type,url|url',
            'team_one_image' => 'nullable|image',
            'team_two_name' => 'required|string|max:191',
            'team_two_image_type' => 'required|string|max:20',
            'team_two_url' => 'nullable|required_if:team_two_image_type,url|url',
            'team_two_image' => 'nullable|image',
			'cover_image_type' => 'required|string|max:20',
            'cover_url' => 'nullable|required_if:cover_image_type,url|url',
            'cover_image' => 'nullable|image',
            'status' => 'required',

            'stream_title' => 'required',
            'stream_title.*' => 'nullable|required_if:is_deleted,no',
            'stream_type' => 'required',
            'stream_type.*' => 'nullable|required_if:is_deleted,no',
            'stream_url' => 'required',
            'stream_url.*' => 'nullable|required_if:is_deleted,no',
            'resulation' => 'required',
            'resulation.*' => 'nullable|required_if:is_deleted,no',
            'name' => 'nullable|required_if:stream_type,restricted',
            'name.*' => 'nullable|required_if:stream_type,restricted',
            'name.*.*' => 'nullable|required_if:stream_type,restricted',
            'value' => 'nullable|required_if:stream_type,restricted',
            'value.*' => 'nullable|required_if:stream_type,restricted',
            'value.*.*' => 'nullable|required_if:stream_type,restricted',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        DB::beginTransaction();

        $live_match = LiveMatch::find($id);

        $live_match->sports_type_id = $request->sports_type_id;
        $live_match->match_title = $request->match_title;
        $live_match->match_time = Carbon::parse($request->match_time)->timestamp;
        $live_match->team_one_name = $request->team_one_name;
        $live_match->team_one_image_type = $request->team_one_image_type;
        $live_match->team_one_url = $request->team_one_url;
        $live_match->team_two_name = $request->team_two_name;
        $live_match->team_two_image_type = $request->team_two_image_type;
        $live_match->team_two_url = $request->team_two_url;
		$live_match->cover_image_type = $request->cover_image_type;
        $live_match->cover_url = $request->cover_url;
        $live_match->status = $request->status;
        
        if ($request->hasFile('team_one_image')) {
            $image = $request->file('team_one_image');
            $ImageName = 'TEAM_' . rand() . '.' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/live_matches/'), $ImageName);
            $live_match->team_one_image = 'public/uploads/images/live_matches/' . $ImageName;
        }

        if ($request->hasFile('team_two_image')) {
            $image = $request->file('team_two_image');
            $ImageName = 'TEAM_' . rand() . '.' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/live_matches/'), $ImageName);
            $live_match->team_two_image = 'public/uploads/images/live_matches/' . $ImageName;
        }
		
		if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $ImageName = 'COVER_' . rand() . '.' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(base_path('public/uploads/images/live_matches/'), $ImageName);
            $live_match->cover_image = 'public/uploads/images/live_matches/' . $ImageName;
        }

        $live_match->save();

        LiveMatchApp::where('match_id', $live_match->id)->delete();
        for ($i=0; $i < count($request->apps); $i++) { 
            
            $app = new LiveMatchApp();

            $app->app_id = $request->apps[$i];
            $app->match_id = $live_match->id;

            $app->save();
			
			$appData = AppModel::where('id', $app->app_id)->first();
			Cache::forget("live_matches_" . $appData->app_unique_id);
        }
		

        StreamingSource::where('match_id', $live_match->id)->delete();
        for ($i=0; $i < count($request->stream_title); $i++) { 
            if($request->stream_title[$i] != '' && $request->stream_type[$i] != '' && $request->stream_url[$i] != '' && $request->is_deleted[$i] != 'yes'){

                $headers = '';

                if ($request->stream_type[$i] == 'restricted') {
                    $h = array();
                    if(isset($request->name[$i]) && isset($request->value[$i])){
                        for ($i2=0; $i2 < count($request->name[$i]); $i2++) { 
                            if($request->name[$i][$i2] != null && $request->value[$i][$i2] != null){
                                $h[$request->name[$i][$i2]] = $request->value[$i][$i2];
                            }
                        }
                    }
                    $headers = json_encode($h);
                }

                $streaming_source = new StreamingSource();

                $streaming_source->match_id = $live_match->id;
                $streaming_source->stream_title = $request->stream_title[$i];
                $streaming_source->resulation = $request->resulation[$i];
                $streaming_source->stream_type = $request->stream_type[$i];
                $streaming_source->stream_url = $request->stream_url[$i];
                $streaming_source->stream_key = $request->stream_type[$i] == 'root_stream' ? $request->stream_key[$i] : '';
                $streaming_source->headers = $request->stream_type[$i] == 'restricted' ? $headers : '';
                $streaming_source->block_country = $request->block_country[$i];
                $streaming_source->is_block_them = $request->is_block_them[$i] ?? 0;

                $streaming_source->save();
            }
        }

        DB::commit(); 
        
        Cache::forget("live_match_$live_match->id");
        Cache::forget("streamingSources_$live_match->id");

        if (!$request->ajax()) {
            return redirect('live_matches')->with('success', _lang('Information has been updated.'));
        } else {
            return response()->json(['result' => 'success', 'redirect' => url('live_matches'), 'message' => _lang('Information has been updated sucessfully.')]);
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
        $live_match = LiveMatch::find($id);
        LiveMatchApp::where('match_id', $live_match->id)->delete();
        StreamingSource::where('match_id', $live_match->id)->delete();
        $live_match->delete();
		
		Cache::forget("live_matches");
        Cache::forget("live_match_$id");
        Cache::forget("streamingSources_$id");

        if (!$request->ajax()) {
            return back()->with('success', _lang('Information has been deleted'));
        } else {
            return response()->json(['result' => 'success', 'message' => _lang('Information has been deleted sucessfully')]);
        }
    }
}
