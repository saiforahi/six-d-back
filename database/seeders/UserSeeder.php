<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'GOD',
            'email' => 'admin@mail.com',
            'phone'=> '01XXXXXXXXX',
            'password' => Hash::make('123456'),
        ]);
        $user=User::where('email','admin@mail.com')->first();
        $user->assignRole('Super-Admin');
    }
}
