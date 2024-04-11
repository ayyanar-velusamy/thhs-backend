<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
		$user->firstname 	= "Admin";
		$user->lastname 	= "";
		$user->name 	= "Adminstrator";
		$user->email 		= "admin@gmail.com";
		$user->password 	= bcrypt('Admin@123');
        $user->position 	= 1;
        $user->is_admin 	= 1;
        $user->status 	= 1;
		$user->save(); 
    }
}
