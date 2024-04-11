<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultiplePositions = [
            ['position' => 'CNA – Certified Nursing Assistant'],
            ['position' => 'DON – Director of Nursing'],
            ['position' => 'HHA – Home Health Aide'],
            ['position' => 'Human Resource'],
            ['position' => 'LPN – Practical Registered Nurse'],
            ['position' => 'MSW – Medical Social Worker'],
            ['position' => 'OT – Occupational Therapist'],
            ['position' => 'OTA - Occupational Therapist Assistant'],
            ['position' => 'PT- Physical Therapist'] ,
            ['position' => 'PTA – Physical Therapist Assistant'],
            ['position' => 'RN- Registered Nurse']   
        ];
        foreach ($createMultiplePositions as $data) {
            $position = new Position();
            $position->position = $data['position'];
            $position->save();
        }
    }
}
