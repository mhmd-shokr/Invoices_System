<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller 
{

        
            public function __construct()
            {
                $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
                $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
                $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
                $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
            }
            
        
    
    public function index(Request $request) {
        $roles=Role::orderBy('id', 'desc')->paginate(2);
        return view('roles.index',compact('roles'))->with('i', ($request->input('page', 1) - 1) * 2);
    }
    public function create(){
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    public function store(Request $request)
    {
    $this->validate($request, [
    'name' => 'required|unique:roles,name',
    'permission' => 'required',
    ]);
    $role = Role::create(['name' => $request->input('name')]);
    $role->syncPermissions($request->input('permission'));
    return redirect()->route('roles.index')
    ->with('success','Role created successfully');
    }

    public function show($id)
    {
        $role = Role::find($id);

        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('permission_id')
            ->toArray();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required|array',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $permissionNames = Permission::whereIn('id', $request->input('permission'))->pluck('name')->toArray();
          $role->syncPermissions($permissionNames);
        return redirect()->route('roles.index')->with('success', 'تم تحديث الدور بنجاح');
    }

    public function destroy($id)
    {
        $role = Role::find($id);

        if ($role) {
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'تم حذف الدور بنجاح');
        }

        return redirect()->route('roles.index')->with('error', 'الدور غير موجود');
    }
    
}
