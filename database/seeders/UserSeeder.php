<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where("email", "anisseam238@gmail.com")->first();
        if(is_null($admin)){
            $admin = new User();
            $admin->first_name = "Muhammad";
            $admin->last_name = "Anisuzzaman";
            $admin->email = "anisseam238@gmail.com";
            $admin->password = Hash::make('password');
            $admin->save();
        }
    }
}
