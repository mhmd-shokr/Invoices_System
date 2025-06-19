<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InvoicesAttachementController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|mimes:pdf,jpeg,jpg,png',
        ],[
            'file_name.mimes' => 'صيغة المرفق يجب أن تكون pdf, jpeg, jpg, png',
        ]);
    
        // Get the uploaded file
        $file = $request->file('file_name');
        $file_name = $file->getClientOriginalName();
    
        // Path where file will be stored
        $path = public_path('attachments/'.$request->invoice_number);
        
        // Create the directory if it doesn't exist
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    
        // Save the attachment information to the database
        invoices_attachement::create([
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $request->invoice_id,
            'file_name' => $file_name,
            'Created_by' => Auth::user()->name,
        ]);
    
        // Move the uploaded file to the correct directory
        $file->move($path, $file_name);
    
        // Return success message
        return redirect()->back()->with('success', 'تم اضافة المرفق بنجاح');
    }

  
}
