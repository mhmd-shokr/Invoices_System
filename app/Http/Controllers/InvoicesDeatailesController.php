<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachement;
use App\Models\invoices_deatailes;
use Illuminate\Http\Request;

class InvoicesDeatailesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $invoices=invoices::where('id',$id)->first();
        $deatailes=invoices_deatailes::where('invoice_id',$id)->get();
        $attachements=invoices_attachement::where('invoice_id',$id)->get();
        return view('invoices.invoices_detailed',compact('invoices','deatailes','attachements'));

    }

   
    public function destroy($id)
    {
        $file = invoices_attachement::findOrFail($id);
        $file_path=public_path('attachments/'.$file->invoice_number.'/'.$file->file_name);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $file->delete();
        return redirect()->back()->with('delete','تم حذف الملف بنجاح');
    }
    public function get_file($invoice_number,$file_name)
    {
        $path = public_path('attachments/'.$invoice_number.'/'.$file_name);
        if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
    }

    public function download_file($invoice_number,$file_name){
        $path = public_path('attachments/'.$invoice_number.'/'.$file_name);
        return response()->download($path);
    }
}
