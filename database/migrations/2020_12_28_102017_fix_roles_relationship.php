<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixRolesRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('model_has_roles')->where('model_type', 'App\User')->update([ 'model_type' => 'App\Models\User']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('model_has_roles')->where('model_type', 'App\Models\User')->update([ 'model_type' => 'App\User']);
    }
}
