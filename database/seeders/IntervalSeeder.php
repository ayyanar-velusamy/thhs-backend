<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Interval;

class IntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultiple = [
            ['name' => 'Day', "uid"=>"eb20b670-7e8f-41f3-b650-7eb7d152dd01"],
            ['name' => 'Hours', "uid"=>"c32b7a5b-ed0b-468b-8e44-3e33085cdd8e"], 
            ['name' => 'Manual', "uid"=>"8604d9da-9248-43ec-883e-4a792225e2c2"],
            ['name' => 'Month', "uid"=>"d33446b0-0851-411a-8790-1da797426cbb"],
            ['name' => 'Week', "uid"=>"91744e2b-fb50-49e5-a9a7-2b63277af3cc"],
            ['name' => 'Year', "uid"=>"bc6baf3c-22de-4054-be16-61622270e884"] 
        ];
        foreach ($createMultiple as $data) {
            $inter = new Interval();
            $inter->name = $data['name'];
            $inter->uid = $data['uid'];
            $inter->status = 1;
            $inter->save();
        }
    }
}
