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
            ['name' => 'Download / Upload'],
            ['name' => 'Report'],
            ['name' => 'Upload Only'] 
        ];
        foreach ($createMultiple as $data) {
            $handle = new Handling();
            $handle->name = $data['name'];
            $handle->status = 1;
            $handle->save();
        }
    }
}
