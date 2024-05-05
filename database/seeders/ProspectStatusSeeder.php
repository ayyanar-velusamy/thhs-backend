<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProspectStatus;

class ProspectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultipleProspectStatuss = [
            [
                'status' => 'Registered', 
            ],
            [
                'status' => 'E-mail Verified',
            ],
            [
                'status' => 'Applied',
            ],
            [
                'status' => 'Waiting for Documents',
            ],
            [
                'status' => 'Interview Scheduled',
            ],
            [
                'status' => 'Interview Confirmed',
            ],            
            [
                'status' => 'Interview Cancelled',
            ],
            [
                'status' => 'Rejected',
            ],
            
            [
                'status' => 'Archived',
            ],
            [
                'status' => 'Re Apply',
            ],
            [
                'status' => 'Hired',
            ],
        ];
        foreach ($createMultipleProspectStatuss as $data) {
            $ProspectStatus = new ProspectStatus();
            $ProspectStatus->status = $data['status'];
            $ProspectStatus->save();
        }
    }
}
