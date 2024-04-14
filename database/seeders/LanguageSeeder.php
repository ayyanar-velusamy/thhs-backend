<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createMultiplePositions = [
            ['language_name' => 'English'],
            ['language_name' => 'French'],
            ['language_name' => 'German'],
            ['language_name' => 'Greek'],
            ['language_name' => 'Hungarian'],
            ['language_name' => 'Italian'],
            ['language_name' => 'Polish'],
            ['language_name' => 'Russia'],
            ['language_name' => 'Spanish'],
            ['language_name' => 'Ukkrainian'],
            ['language_name' => 'Yiddish'],
        ];
        foreach ($createMultiplePositions as $data) {
            $position = new Language();
            $position->language_name = $data['language_name'];
            $position->save();
        }
    }
}
