<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        if (env('DB_MIGRATION', 0) == 1) {
            $old_record = DB::connection('mysql_old')->table('staffrole')->get();
            foreach ($old_record as $data) {
                $position = new Position();
                $position->short_name = $data->Name;
                $position->position = $data->Name;
                $position->old_id = $data->StaffRoleId;
                $position->save(); 
            }
        } else {
            $createMultiplePositions = [
                [
                    'short_name' => 'CNA',
                    'position' => 'Certified Nursing Assistant',
                ],
                [
                    'short_name' => 'DON',
                    'position' => 'Director of Nursing',
                ] 
            ];
            foreach ($createMultiplePositions as $data) {
                $position = new Position();
                $position->short_name = $data['short_name'];
                $position->position = $data['position'];
                $position->save();
            }
        }
    }
}
