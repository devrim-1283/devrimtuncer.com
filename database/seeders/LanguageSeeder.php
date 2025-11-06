<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::create([
            'code' => 'tr',
            'name' => 'Turkish',
            'native_name' => 'Türkçe',
            'is_active' => true,
            'is_default' => true,
            'sort_order' => 1,
        ]);

        Language::create([
            'code' => 'en',
            'name' => 'English',
            'native_name' => 'English',
            'is_active' => true,
            'is_default' => false,
            'sort_order' => 2,
        ]);
    }
}
