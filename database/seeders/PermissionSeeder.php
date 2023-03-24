<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissins = [
            ['title' => 'dashboard'],
            ['title' => 'Add News'],
            ['title' => 'Delete News'],
            ['title' => 'Update News'],
            ['title' => 'View News'],
            ['title' => 'Add Project'],
            ['title' => 'Delete Project'],
            ['title' => 'Update Project'],
            ['title' => 'View Project'],
            ['title' => 'Add Service'],
            ['title' => 'Delete Service'],
            ['title' => 'Update Service'],
            ['title' => 'View Service'],
            ['title' => 'Add Job'],
            ['title' => 'Delete Job'],
            ['title' => 'Update Job'],
            ['title' => 'View Job'],
            ['title' => 'Add Gallery'],
            ['title' => 'Delete Gallery'],
            ['title' => 'Update Gallery'],
            ['title' => 'View Gallery'],
            ['title' => 'Add User'],
            ['title' => 'Delete User'],
            ['title' => 'Update User'],
            ['title' => 'View User'],
            ['title' => 'Add Role'],
            ['title' => 'Delete Role'],
            ['title' => 'Update Role'],
            ['title' => 'View Role'],
            ['title' => 'Add Team'],
            ['title' => 'Delete Team'],
            ['title' => 'Update Team'],
            ['title' => 'View Team'],
            ['title' => 'Add Department'],
            ['title' => 'Delete Department'],
            ['title' => 'Update Department'],
            ['title' => 'View Department'],
            ['title' => 'Add Category'],
            ['title' => 'Delete Category'],
            ['title' => 'Update Category'],
            ['title' => 'View Category'],
            ['title' => 'Add Applicant'],
            ['title' => 'Delete Applicant'],
            ['title' => 'Update Applicant'],
            ['title' => 'View Applicant'],
        ];

        $role= Role::create(['title'=>'admin']);
        User::create([
           'f_name'=>'Amare',
           'l_name'=>'Hore',
           'email'=>'alemteb1010@gmail.com',
           'phone_no'=>'0908765666',
           'password'=>Hash::make('12345678'),
           'role_id'=>$role->id,
        ]);
        foreach ($permissins as $p) {
       $pp= Permission::create($p);

       PermissionRole::create(['role_id'=>$role->id,'permission_id'=>$pp->id]);

        }
    }
}
