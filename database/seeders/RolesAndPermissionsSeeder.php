<?php

namespace Database\Seeders;

use App\Constants;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Artisan::call('migrate:fresh');

        $permission = collect(Constants::PERMISSIONS)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web', 'created_at' => now(), 'updated_at'=> now()];
        });
        Permission::insert($permission->toArray());

        $adminRole = Role::create(['name' => 'admin'])
            ->givePermissionTo(Constants::ADMIN_PERMISSIONS);

        $userRole = Role::create(['name' => 'user'])
            ->givePermissionTo(Constants::USER_PERMISSIONS);

        $admin = User::create([
            'name' => 'John Admin',
            'email' => 'john@gmail.com',
            'username' => 'Jonny',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);
        $admin->givePermissionTo(Permission::all());

        $user = User::create([
            'name' => 'Doe User',
            'email' => 'doe@gmail.com',
            'username' => 'Doe',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($userRole);
        $admin->givePermissionTo(Constants::USER_PERMISSIONS);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');                                                                                                                                                                 
    }
}
