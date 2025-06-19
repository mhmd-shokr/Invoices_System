<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reports.index');
    }

    public function SearchInvoices(Request $request){
        $rdio=$request->rdio;

        if($rdio == 1){

                if($request->type && $request->start_at == "" && $request->end_at == "")
                {
                    $invoices=invoices::select('*')->where('status',$request->type)->get();
                    $type=$request->type;
                    return view('reports.index', compact('type'))->with('details', $invoices);
                }
                else
                {
                    $start_at=date($request->start_at);
                    $end_at=date($request->end_at);
                    $type = $request->type;
                    $invoices=invoices::whereBetween('invoices_date',[$start_at,$end_at])->where('status',$request)->get();
                    return view('reports.index',compact('type','start_at','end_at'))->with('details',$invoices);

                }

        }
        else
        {
                    $invoices=invoices::select('*')->where('invoice_number',$request->invoice_number)->get();
                    return view('reports.index')->with('details', $invoices);

        }
    }
}
