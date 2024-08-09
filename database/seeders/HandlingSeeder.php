<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Handling;

class HandlingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultiple = [
            ['name' => 'Download / Upload', "uid" =>"71e9749b-d59a-427c-a3b9-94c23091ac9a"],
            ['name' => 'Report', "uid" =>"3c46fd06-523b-4683-bf96-0e187b8a645c"],
            ['name' => 'Upload Only', "uid" =>"e877998a-97a5-459c-ac7d-84276de4bc9d"] 
            
        ];
        foreach ($createMultiple as $data) {
            $handle = new Handling();
            $handle->name = $data['name'];
            $handle->uid = $data['uid'];
            $handle->status = 1;
            $handle->save();
        }
    }
}
