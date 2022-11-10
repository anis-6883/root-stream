<?php

namespace App\Http\Controllers;

use App\Models\SportsType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SportsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('sports_type.view')) 
        {
            $sports_types = SportsType::orderBy('id', 'DESC')->get();

            if($request->ajax()) {
                return DataTables::of($sports_types)
                ->addColumn('status', function($sports_type){
                    if($sports_type->status == 1){
                        return '<span class="badge rounded-pill border border-success text-success">Active</span>';
                    }else{
                        return '<span class="badge rounded-pill border border-danger text-danger">In-Active</span>';
                    }
                })
                ->addColumn('created_at', function($sports_type) {
                    return date("M d, Y H:i:s", strtotime($sports_type->created_at));
                })
                ->addColumn('action', function($sports_type) {
                    return '<div class="dropdown">
                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="' . route('sports_types.edit', $sports_type->id) . '" class="dropdown-item ajax-modal" data-title="Edit Sports Type">
                                            <i class="fas fa-edit"></i>
                                                Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="' . route('sports_types.destroy', $sports_type->id) . '" method="post" class="ajax-delete">'
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
                ->rawColumns(['status', 'created_at', 'action'])
                ->make(true);
            }
            return view('sports_types.index');
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
        if (!$request->ajax()) {
            return view('sports_types.create');
        } else {
            return view('sports_types.modal.create');
        }
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

            'sports_name' => 'required|string|max:100|unique:sports_types,sports_name',
            'sports_skq' => 'required|string|max:100',
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $sports_type = new SportsType();

        $sports_type->sports_name = $request->sports_name;
        $sports_type->sports_skq = $request->sports_skq;
        $sports_type->status = $request->status;

        $sports_type->save();

        if (!$request->ajax()) {
            return redirect('sports_types')->with('success', _lang('Information has been added sucessfully!'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Information has been added sucessfully!')]);
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
        $sports_type = SportsType::find($id);

        if (!$request->ajax()) {
            return view('sports_types.edit', compact('sports_type'));
        } else {
            return view('sports_types.modal.edit', compact('sports_type'));
        }
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

            'sports_name' => 'required|string|max:100|unique:sports_types,sports_name,' . $id,
            'sports_skq' => 'required|string|max:100',
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $sports_type = SportsType::find($id);

        $sports_type->sports_name = $request->sports_name;
        $sports_type->sports_skq = $request->sports_skq;
        $sports_type->status = $request->status;

        $sports_type->save();

        if (!$request->ajax()) {
            return redirect('sports_types')->with('success', _lang('Information has updated added sucessfully!'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Information has been updated sucessfully!')]);
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
        $sports_type = SportsType::find($id);
        $sports_type->delete();

        if (!$request->ajax()) {
            return back()->with('success', _lang('Information has been deleted sucessfully!'));
        } else {
            return response()->json(['result' => 'success', 'message' => _lang('Information has been deleted sucessfully!')]);
        }
    }
}
