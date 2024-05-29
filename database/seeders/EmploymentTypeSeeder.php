<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmploymentType;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultipleRole = [
            ['type' => 'Contract'],
            ['type' => 'Staff'],
            ['type' => 'Corporation'],
            ['type' => 'Temporary']   
        ];
        foreach ($createMultipleRole as $data) {
            $schema = new EmploymentType();
            $schema->type = $data['type'];
            $schema->status = 1;
            $schema->save();
        }
    }
}
