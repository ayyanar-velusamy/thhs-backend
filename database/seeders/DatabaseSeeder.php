<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([           
            PositionSeeder::class,
            LanguageSeeder::class,
            UserRoleSeeder::class,
            OrganizationSeeder::class,
            ProspectStatusSeeder::class,
            StaffStatusSeeder::class,
            IntervalSeeder::class,
            EmploymentTypeSeeder::class,
            HandlingSeeder::class,
            ChartCategorySeeder::class,
            ChartSeeder::class,
            UserSeeder::class,
            ProspectSeeder::class,
        ]);
    }
}
