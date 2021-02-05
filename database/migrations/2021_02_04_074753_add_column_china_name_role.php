<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

class AddColumnChinaNameRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('roles', function (Blueprint $table) {
            $table->string('chinese_name', 30)->after('guard_name')->nullable()->comment('中文名字');
        });
        $roles = Role::all();
        foreach($roles as $role) {
            if ($role->name === 'Admin') {
                $role->chinese_name = '管理員';
            }
            if ($role->name === 'User') {
                $role->chinese_name = '主播';
            }
            $role->save();
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
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('chinese_name');
        });
    }
}
