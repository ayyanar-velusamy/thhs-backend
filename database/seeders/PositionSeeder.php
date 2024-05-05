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
            [
                'short_name' => 'CNA', 
                'position' => 'Certified Nursing Assistant'
            ],
            [
                'short_name' => 'DON',
                'position' => 'Director of Nursing'
            ],
            [
                'short_name' => 'HHA',
                'position' => 'Home Health Aide'
            ],
            [
                'short_name' => 'HR',
                'position' => 'Human Resource'
            ],
            [
                'short_name' => 'LPN',
                'position' => 'Practical Registered Nurse'
            ],
            [
                'short_name' => 'MSW',
                'position' => 'Medical Social Worker'
            ],
            [
                'short_name' => 'OT',
                'position' => 'Occupational Therapist'
            ],
            [
                'short_name' => 'OTA',
                'position' => 'Occupational Therapist Assistant'
            ],
            [
                'short_name' => 'PT',
                'position' => 'Physical Therapist'
            ] ,
            [
                'short_name' => 'PTA',
                'position' => 'Physical Therapist Assistant'
            ],
            [
                'short_name' => 'RN',
                'position' => 'Registered Nurse'
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
