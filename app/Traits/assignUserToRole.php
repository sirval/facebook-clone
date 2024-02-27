<?php

namespace App\Traits;

use App\Constants;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait assignUserToRole 
{
    /*|--------------------------------------------------------------|
        Check if role is equal to each role in system roles
        then assign roles and direct permissions to the user. 
    |----------------------------------------------------------------|*/
    private function assignDefaultRoles($user, $myRole):bool|string
    {
        $role = Role::where('name', $myRole)->first();
        if ($role->name === 'admin') {

            $newRole = $role->givePermissionTo(Permission::all()); // give permission to user role
            $user->assignRole($newRole);
            $user->givePermissionTo(Permission::all()); //give direct permission to user
            return $newRole ? true : false;

        }else if($role->name === 'user'){

            $newRole = $role->givePermissionTo(Constants::USER_PERMISSIONS); // give permission to user role
            $user->assignRole($newRole);
            $user->givePermissionTo(Constants::USER_PERMISSIONS); //give direct permission to user
            return $newRole ? true : false;

        }else{
            return "UNKNOWN";
        }
    }
}