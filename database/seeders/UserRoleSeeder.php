<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;
use DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->truncate(); 
        if (env('DB_MIGRATION', 0) == 1) { 
            $old_record = DB::connection('mysql_old')->table('role')->get();
            foreach ($old_record as $data) {
                $schema = new UserRole();
                $schema->role = $data->Name;
                $schema->status = 1;
                $schema->old_id = $data->RoleId;
                $schema->save();
            } 
        } else {
            $createMultipleRole = [
                ['role' => 'User'],
                ['role' => 'Admin'],
            ];
            foreach ($createMultipleRole as $data) {
                $schema = new UserRole();
                $schema->role = $data['role'];
                $schema->status = 1;
                $schema->save();
            }
        } 
    }
}
