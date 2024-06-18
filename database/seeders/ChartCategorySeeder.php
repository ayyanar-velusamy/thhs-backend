<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartCategory;

class ChartCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultipleRole = [
            ['name' => 'Certificates'],
            ['name' => 'Competencies'],   
            ['name' => 'General HR']   
        ];
        foreach ($createMultipleRole as $data) {
            $schema = new ChartCategory();
            $schema->name = $data['name'];
            $schema->status = 1;
            $schema->save();
        }
    }
}
