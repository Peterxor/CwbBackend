<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\User;

class InsertANewUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);
        $user->assignRole('Admin');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        User::where('name', 'admin')->delete();
    }
}
