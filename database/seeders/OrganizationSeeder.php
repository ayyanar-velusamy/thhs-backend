<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultiple = [
            ['name' => 'HHA Facility'],
            ['name' => 'HHA Management'] 
        ];
        foreach ($createMultiple as $data) {
            $schema = new Organization();
            $schema->name = $data['name'];
            $schema->status = 1;
            $schema->save();
        }
    }
}
