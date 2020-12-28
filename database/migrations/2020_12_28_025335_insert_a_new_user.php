<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

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
