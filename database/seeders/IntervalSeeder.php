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
            ['name' => 'Day'],
            ['name' => 'Hours'], 
            ['name' => 'Month'],
            ['name' => 'Week'],
            ['name' => 'Year'] 
        ];
        foreach ($createMultiple as $data) {
            $inter = new Interval();
            $inter->name = $data['name'];
            $inter->status = 1;
            $inter->save();
        }
    }
}
