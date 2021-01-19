<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;

class InsertNewPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $new_permission = [
            'view_dashboard',
            'edit_dashboard',
            'view_personnel',
            'edit_personnel',
            'add_personnel',
            'view_anchor',
            'edit_anchor',
            'view_device',
            'edit_device',
            'view_weather',
            'edit_weather',
            'view_typhoon',
            'edit_typhoon',
            'view_logs',
            'upload_media',
        ];
        foreach ($new_permission as $p) {
            Permission::query()->create([
                'name' => $p
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Permission::query()->whereIn('name', [
            'view_dashboard',
            'edit_dashboard',
            'view_personnel',
            'edit_personnel',
            'add_personnel',
            'view_anchor',
            'edit_anchor',
            'view_device',
            'edit_device',
            'view_weather',
            'edit_weather',
            'view_typhoon',
            'edit_typhoon',
            'view_logs',
            'upload_media',
            ])->delete();
    }
}
