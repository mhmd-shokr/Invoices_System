<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class ArchiveController extends Controller
{

    public function index()
    {
        $invoices=invoices::onlyTrashed()->get();
        return view('invoices.Archive',compact('invoices'));
    }



    public function update(Request $request)
    {
        $id=$request->invoice_id;
        $invoice=invoices::withTrashed()->where('id','=',$id);
        if (!$invoice) {
            return redirect()->back()->with('error', 'الفاتورة غير موجودة.');
        }
        $invoice->restore();
        return redirect()->route('invoices.index')->with('success', '✅ تم إلغاء أرشفة الفاتورة بنجاح!');
    }

    public function destroy(string $id)
    {
        $invoice = invoices::onlyTrashed()->findOrFail($id);
        $invoice->forceDelete();
    
        return redirect()->route('invoices.index')->with('success', 'تم حذف الفاتورة نهائياً.');
    }
    
}
