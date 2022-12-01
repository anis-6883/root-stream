<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use App\Models\PopularSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PopularSeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('popular_series.view')) 
        {
            $popular_series = PopularSeries::orderBy('id', 'DESC');

            if ($request->ajax()) {
                return DataTables::of($popular_series)
                    ->addColumn('status', function($series){
                        if($series->status == 1){
                            return '<span class="badge rounded-pill border border-success text-success">Active</span>';
                        }else{
                            return '<span class="badge rounded-pill border border-danger text-danger">In-Active</span>';
                        }
                    })
                    ->addColumn('action', function($series){
                        return '<div class="dropdown">
                                    <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="' . route('popular_series.edit', $series->id) . '" class="dropdown-item">
                                                <i class="fas fa-edit"></i>
                                                    Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="' . route('popular_series.destroy', $series->id) . '" method="post" class="ajax-delete">'
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
                    ->setRowId(function ($series) {
                        return "row_" . $series->id;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
            return view('popular_series.index');
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
        if(Auth::user()->can('popular_series.create')) 
        {
            $apps = AppModel::where('status', 1)->get();
            return view('popular_series.create', compact('apps'));
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
			
			'apps' => 'required',
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'action_url' => 'required|url',
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $series = new PopularSeries();
		
		$series->apps = json_encode($request->apps);
        $series->title = $request->title;
        $series->description = $request->description;
        $series->action_url = $request->action_url;
        $series->status = $request->status;

        $series->save();

        for ($i=0; $i < count($request->apps); $i++) { 
            $app_unique_id = AppModel::find($request->apps[$i])->app_unique_id;
            Cache::forget('popular_series_' . $app_unique_id);
        }

        if (!$request->ajax()) {
            return redirect('popular_series')->with('success', _lang('Information has been added.'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Information has been added sucessfully.')]);
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
        if(Auth::user()->can('popular_series.edit')) 
        {
            $series = PopularSeries::findOrFail($id);
            return view('popular_series.edit', compact('series'));
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
			
			'apps' => 'required',
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'action_url' => 'required|url',
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $series = PopularSeries::find($id);
		
		$series->apps = json_encode($request->apps);
        $series->title = $request->title;
        $series->description = $request->description;
        $series->action_url = $request->action_url;
        $series->status = $request->status;

        $series->save();

        for ($i=0; $i < count($request->apps); $i++) { 
            $app_unique_id = AppModel::find($request->apps[$i])->app_unique_id;
            Cache::forget('popular_series_' . $app_unique_id);
        }

        if (!$request->ajax()) {
            return redirect('popular_series')->with('success', _lang('Information has updated added.'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Information has been updated sucessfully.')]);
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
        $series = PopularSeries::find($id);
        $apps = json_decode($series->apps);

        for ($i=0; $i < count($apps); $i++) { 
            $app_unique_id = AppModel::find($apps[$i])->app_unique_id;
            Cache::forget('popular_series_' . $app_unique_id);
        }

        $series->delete();

        if (!$request->ajax()) {
            return back()->with('success', _lang('Information has been deleted'));
        } else {
            return response()->json(['result' => 'success', 'message' => _lang('Information has been deleted sucessfully')]);
        }
    }
}
