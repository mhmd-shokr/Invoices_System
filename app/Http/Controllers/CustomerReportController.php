<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;
use App\Models\sections;

class CustomerReportController extends Controller
{
    public function index()
    {
        $sections = sections::all();
        return view('reports.customer',compact('sections'));
    }

    public function  searchCustomers(Request $request)
    {
        
            if($request->Section && $request->product && $request->start_at =='' && $request->end_at=='')
            {
                $invoices=invoices::select('*')->where('section_id',$request->Section)->where('product',$request->product)->get();
                $sections = sections::all();
            return view('reports.customer',compact('sections'))->with('details',$invoices);

            }else
            {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $invoices = invoices::whereBetween('invoices_date',[$start_at,$end_at])->where('section_id',$request->Section)->where('product',$request->product)->get();
                $sections = sections::all();
                return view('reports.customer',compact('sections'))->with('details',$invoices);
            }
    }
}
