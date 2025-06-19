<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=sections::all();
        return view('sections.section',compact('sections'));
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_name' => 'required|string|max:255|unique:sections,section_name',
            'description' => 'nullable|string|max:500',
        ],[
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم موجود بالفعل',
            'description.max' => 'الوصف يجب ان يكون اقل من 500 حرف',
            'section_name.max' => 'اسم القسم يجب ان يكون اقل من 255 حرف',
        ]);
    
        $section = Sections::create([
            'section_name' => $validated['section_name'],
            'description' => $validated['description'],
            'Created_by' => Auth::user()->name,
        ]);
    
        if ($section) {
            return redirect()->route('sections.index')->with('success', '✅ تم إضافة القسم بنجاح!');
        } else {
            return redirect()->back()->withInput()->with('error', '❌ حدث خطأ أثناء إضافة القسم، حاول مرة أخرى.');
        }
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        
        $request->validate([
                'section_name' => 'required|string|max:255|unique:sections,section_name,' . $id,
                'description' => 'nullable|string|max:500',
        ],[
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم موجود بالفعل',
            'description.max' => 'الوصف يجب ان يكون اقل من 500 حرف',
            'section_name.max' => 'اسم القسم يجب ان يكون اقل من 255 حرف',
        ]);

        $section = sections::findOrFail($id);

        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description
        ]);
        return redirect()->route('sections.index')->with('success', '✅ تم تعديل القسم بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $section=Sections::findOrFail($id);
        $section->delete();
        return redirect()->back()->with('success', '✅ تم حذف القسم بنجاح!');
    }
}
