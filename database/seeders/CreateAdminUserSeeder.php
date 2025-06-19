<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=User::create([
            'name'=>'mohamed',
            'email'=>'mohamed212shokr@gmail.com',
            'password'=>bcrypt('123123123'),
            'roles_name'=>["owner"],
            'status'=>'مفعل',
        ]);
        $role=Role::create(['name'=>'owner']);
        $permission=Permission::pluck('id','id')->all();
        $role->syncPermissions($permission);
        $user->assignRole([$role->id]);

    }
}
