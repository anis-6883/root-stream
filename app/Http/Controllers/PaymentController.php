<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $app_unique_id = '')
    {
        if(Auth::user()->can('payment.view'))
        {
            $app_unique_id = $request->id;
            $payments = [];
            if($app_unique_id != ''){
                $payments = Payment::with('user', 'subscription')->whereHas('app', function($query) use($app_unique_id) {
                                                $query->where('app_unique_id', $app_unique_id);
                                            })
                                            ->orderBy('id', 'DESC');
            }
    
            if ($request->ajax()) {
                return DataTables::of($payments)
                    ->editColumn('platform', function ($payment) {
                        return strtoupper($payment->platform);
                    })
                    ->editColumn('created_at', function ($payment) {
                        return date('M d, Y H:i', strtotime($payment->created_at));
                    })
                    // ->addColumn('action', function($payment) {
                    //     return '<div class="dropdown">
                    //                 <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    //                 Action
                    //                 </button>
                    //                 <ul class="dropdown-menu">
                    //                     <li>
                    //                         <a href="' . route('payments.show', $payment->id) . '" class="dropdown-item ajax-modal" data-title="' . _lang('Details') . '">
                    //                             <i class="fas fa-edit"></i>
                    //                             ' . _lang('Details') . '
                    //                         </a>
                    //                     </li>
                    //                 </ul>
                    //         </div>';
                    // })
                    // ->rawColumns(['action'])
                    ->make(true);
            }
    
            return view('payments.index', compact('payments', 'app_unique_id'));
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$request->ajax()) {
            return view('payments.modal.show', compact('payment'));
        } else {
            return view('payments.modal.show', compact('payment'));
        }
    }
}
