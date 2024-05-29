<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultipleRole = [
            ['role' => 'User'],
            ['role' => 'Admin']   
        ];
        foreach ($createMultipleRole as $data) {
            $schema = new UserRole();
            $schema->role = $data['role'];
            $schema->status = 1;
            $schema->save();
        }
    }
}
