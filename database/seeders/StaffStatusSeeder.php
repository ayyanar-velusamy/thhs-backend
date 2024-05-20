<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaffStatus;

class StaffStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultipleStaffStatus = [
            [
                'status' => 'Active', 
            ],
            [
                'status' => 'Pending',
            ],
            [
                'status' => 'Archive',
            ],
            [
                'status' => 'Terminate',
            ],
            [
                'status' => 'Deleted', 
            ],
        ];
        foreach ($createMultipleStaffStatus as $data) {
            $StaffStatus = new StaffStatus();
            $StaffStatus->status = $data['status'];
            $StaffStatus->save();
        }
    }
}
