<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_deatailes;
use Illuminate\Http\Request;
use App\Models\sections;
use App\Models\products;
use App\Models\invoices_attachement;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoiceExcel;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices=invoices::all();
        return view('invoices.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections=sections::all();
        $products=products::all();

        return view('invoices.addInvoices',compact('sections','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'invoice_number' => 'required|string|unique:invoices,invoice_number|max:50',
        'invoice_Date' => 'required|date',
        'Due_date' => 'required|date|after_or_equal:invoice_date',
        'product' => 'required|string|max:100',
        'section' => 'required|exists:sections,id',
        'Amount_collection' => 'required|numeric|min:0',
        'Amount_Commission' => 'required|numeric|min:0',
        'Discount' => 'nullable|numeric|min:0',
        'Rate_VAT' => 'nullable|string|max:10',
        'value_vat' => 'nullable|numeric|min:0', 
        'note' => 'nullable|string|max:1000',
        'pic' => 'nullable|mimes:jpeg,jpg,png,gif,pdf|max:10000',
    ], [
        'invoice_number.required' => 'يرجي ادخال رقم الفاتورة',
        'invoice_number.unique' => 'رقم الفاتورة مسجل من قبل',
        'invoice_Date.required' => 'يرجي ادخال تاريخ الفاتورة',
        'Due_date.required' => 'يرجي ادخال تاريخ الاستحقاق',
        'product.required' => 'يرجي ادخال اسم المنتج',
        'section.required' => 'يرجي ادخال اسم القسم',
        'Amount_collection.required' => 'يرجي ادخال مبلغ التحصيل',
        'Amount_Commission.required' => 'يرجي ادخال مبلغ العمولة',
        'pic.mimes' => 'صيغة المرفق يجب أن تكون: jpeg, jpg, png, pdf, gif.',
        'pic.max' => 'يجب ألا يتجاوز حجم الملف 10 ميجابايت.',
    ]);

    // Insert the invoice data into the 'invoices' table
    $invoice = invoices::create([
        'invoice_number' => $request->invoice_number,
        'invoices_date' => $request->invoice_Date,
        'due_date' => $request->Due_date,
        'product' => $request->product,
        'section_id' => $request->section,
        'Ammount_collection' => $request->Amount_collection,
        'Ammount_commission' => $request->Amount_Commission,
        'discount' => $request->Discount,
        'rat_vat' => $request->Rate_VAT ?? '0%',
        'value_vat' => $request->Value_VAT,
        'total' => $request->Total,
        'status' => 'غير مدفوعة',
        'value_status' => 2,
        'note' => $request->note,
        'user' => Auth::user()->name,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Insert invoice details
    invoices_deatailes::create([
        'invoice_id' => $invoice->id,
        'invoice_number' => $request->invoice_number,
        'product' => $request->product,
        'section' => $request->section,
        'status' => 'غير مدفوعة',
        'value_status' => 2,
        'user' => Auth::user()->name,
        'note' => $request->note,
    ]);
// get the last id of the invoice to send it in the notification to receivers can see the invoice
    $invoice_id=Invoices::latest()->first()->id;

    // Handle attachments
    //besure that the pic is not null and it come from the form 
    if ($request->hasFile('pic')) {

        $image = $request->file('pic');
    // get the base file name to store in the database  

        $file_name =$image->getClientOriginalName();
    //
        invoices_attachement::create([
            'file_name' => $file_name,
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $invoice->id,
            'Created_by' => Auth::user()->name,
        ]);
    // select the folder to store the pic public/attachments/{رقم_الفاتورة}
        $destinationPath = public_path('attachments/' . $request->invoice_number);
        if (!file_exists($destinationPath)) {
            
            mkdir($destinationPath, 0777, true);
        }
        // move the base file to the folder
        $image->move($destinationPath, $file_name);
    }

    $user=User::first();
    Notification::send($user,new AddInvoice($invoice_id));

    return redirect()->back()->with('success', '  ✅ تم اضافة الفاتورة بنجاح!');
}


    public function show($id)
    {
        $sections=sections::all();
        $products=products::all();
        $invoices=invoices::where('id','=',$id)->first();
        return view('invoices.Status_updata',compact('invoices','sections','products'));
    }

    public function edit($id)
    {
        $invoices=invoices::where('id','=',$id)->first();
        $sections=sections::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));
    }

    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);

        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoices_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'section_id' => $request->section,
            'product' => $request->product,
            'Ammount_collection' => $request->Amount_collection,
            'Ammount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rat_vat' => $request->Rate_VAT ??'0%',
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'note' => $request->note,
            'user' => Auth::user()->name,
            'updated_at' => now(),
        ]);
        return redirect()->route('invoices.index')->with('success', '✅ تم تعديل الفاتورة بنجاح!');
    }
    public function getProducts($id)
    {
        $products=DB::table('products')->where('section_id','=',$id)->pluck('product_name','id');
        return json_encode($products);
    }

    public function destroy(Request $request){
        $id = $request->id_invoice;
        $id_page = $request->id_page;
        $invoice = invoices::where('id', $id)->first();
        if (!$invoice) {
            return redirect()->back()->with('error', 'الفاتورة غير موجودة');
        }
        if ($id_page != 2) {
            $attachments = invoices_attachement::where('invoice_id', $id)->get();
            foreach ($attachments as $attachment) {
                $file = public_path('attachments/'.$invoice->invoice_number.'/'.$attachment->file_name);
                if (file_exists($file)) {
                    unlink($file);
                }
                $attachment->delete();
            }
            $folder_path = public_path('attachments/'.$invoice->invoice_number);
            if (file_exists($folder_path)) {
                rmdir($folder_path);
            }
            invoices_deatailes::where('invoice_id', $id)->delete();
            $invoice->forceDelete();
            return redirect()->route('invoices.index')->with('delete_invoice', '✅ تم حذف الفاتورة نهائيًا بنجاح!');
        } else {
            $invoice->delete();
            return redirect()->route('invoices_archive.index')->with('archive_invoice', '✅ تم نقل الفاتورة إلى الأرشيف!');

        }
    }
    
    public function Status_Update($id, Request $request)
    {
        $invoice = invoices::findOrFail($id);
    
        if ($request->Status == 'مدفوعة') {
            $value_status = 1;
        } elseif ($request->Status == 'غير مدفوعة') {
            $value_status = 2;
        } else {
            $value_status = 3;
        }
    
        $invoice->update([
            'value_status' => $value_status,
            'status' => $request->Status,
            'payment_date' => $request->payment_date,
        ]);
    
        invoices_deatailes::create([
            'invoice_id' => $request->invoice_id,
            'invoice_number' => $request->invoice_number,
            'status' => $request->Status,
            'value_status' => $value_status,
            'section' => $request->section,
            'product' => $request->product,
            'payment_date' => $request->payment_date,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);
    
        return redirect()->route('invoices.index')->with('success', 'تم تحديث الحالة بنجاح');
    }


    public function invoice_paid() {
        $invoices = invoices::where('value_status', '=', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }
    
    public function invoice_unpaid() {
        $invoices = invoices::where('value_status', '=', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }
    
    public function invoice_partial() {
        $invoices = invoices::where('value_status', '=', 3)->get();
        return view('invoices.invoices_partial', compact('invoices'));
    }

    public function print_invoice($id){
        $invoices=invoices::where('id','=',$id)->first();
        return view('invoices.print_invoice',compact('invoices'));
    }

    public function export(){
        return Excel::download(new InvoiceExcel, 'invoices.xlsx');
    }

}

