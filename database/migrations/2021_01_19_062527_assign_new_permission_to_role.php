<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;
use App\Models\Role;

class AssignNewPermissionToRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user_permission_name = [
            'view_anchor',
            'edit_anchor',
        ];

        $admin_permissions = Permission::all();
        $user_permissions = Permission::query()->whereIn('name', $user_permission_name)->get();
        $admin_role = Role::query()->where('name', 'Admin')->first();
        $user_role = Role::query()->where('name', 'User')->first();

        $admin_role->syncPermissions($admin_permissions);
        $user_role->syncPermissions($user_permissions);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $admin_permission_name = Permission::defaultPermissions();

        $user_permission_name = [
            'view_users',
            'view_roles',
        ];
        $admin_permissions = Permission::query()->whereIn('name', $admin_permission_name)->get();
        $user_permissions = Permission::query()->whereIn('name', $user_permission_name)->get();
        $admin_role = Role::query()->where('name', 'Admin')->first();
        $user_role = Role::query()->where('name', 'User')->first();

        $admin_role->syncPermissions($admin_permissions);
        $user_role->syncPermissions($user_permissions);


    }
}
