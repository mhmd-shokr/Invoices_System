<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request) {
        $data=User::orderBy('id', 'desc')->paginate(2);
        return view('users.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 2);
    }
    public function create(){
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create',compact('roles'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required|array',
            'Status' => 'required|string',
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'roles_name' => json_encode($input['roles_name']),
            'status' => $input['status'],
        ]);
    
        $user->assignRole($request->input('roles_name'));
    
        return redirect()->route('users.index')->with('success','تم اضافة المستخدم بنجاح');
    }
    public function show($id)
{
    $user = User::find($id);
    return view('users.show', compact('user'));
}
public function edit($id)
{
    $user = User::find($id);
    $roles = Role::pluck('name','name')->all(); // قائمة بجميع الأدوار
    $userRole = $user->roles->pluck('name','name')->all(); // أدوار المستخدم الحالي

    return view('users.edit', compact('user','roles','userRole'));
}
public function update(Request $request, $id)
{
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'same:confirm-password',
        'roles' => 'required'
    ]);

    $input = $request->all();

    if (!empty($input['password'])) {
        $input['password'] = Hash::make($input['password']);
    } else {
        $input = Arr::except($input, ['password']);
    }

    $user = User::find($id);
    $user->update($input);

    // نحذف الأدوار القديمة
    DB::table('model_has_roles')->where('model_id', $id)->delete();

    // نضيف الأدوار الجديدة
    $user->assignRole($request->input('roles'));

    return redirect()->route('users.index')->with('success','تم تحديث معلومات المستخدم بنجاح');
}
public function destroy(Request $request)
{
    User::find($request->user_id)->delete();
    return redirect()->route('users.index')->with('success','تم حذف المستخدم بنجاح');
}

    
    
}
