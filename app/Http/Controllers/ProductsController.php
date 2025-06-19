<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=sections::all();  
        $products=products::all();
        return view('products.products',compact('products','sections'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name',
            'description' => 'nullable|string|max:500',
        ],[
            'product_name.required' => 'يرجى ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج موجود بالفعل',
            'description.max' => 'الوصف يجب ان يكون اقل من 500 حرف',
            'product_name.max' => 'اسم المنتج يجب ان يكون اقل من 255 حرف',
        ]);

        $product= products::create([
            'product_name' => $validated['product_name'],
            'description' => $validated['description'],
            'section_id' => $request->section_id,
            'Created_by' => Auth::user()->name,
        ]);

        if ($product) {
            return redirect()->route('products.index')->with('success', '✅ تم إضافة المنتج بنجاح!');
        } else {
            return redirect()->back()->withInput()->with('error', '❌ حدث خطأ أثناء إضافة المنتج، حاول مرة أخرى.');
        }
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name,' . $id,
            'section_id'   => 'nullable|integer',
            'description'  => 'nullable|string',
        ],[
            'product_name.required' => 'يرجى ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج موجود بالفعل',
            'description.max' => 'الوصف يجب ان يكون اقل من 500 حرف',
            'product_name.max' => 'اسم المنتج يجب ان يكون اقل من 255 حرف',
            'section_id.integer' => 'يرجى ادخال قسم صحيح',        
        ]);
        $product = products::findOrFail($id);
        $product->update([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        return redirect()->back()->with('success', 'تم تعديل المنتج بنجاح!');
    }
    public function destroy($id)
    {
        $products=products::findOrFail($id);
        $products->delete();
        return redirect()->back()->with('success', '✅ تم حذف المنتج بنجاح!');
    }
}
