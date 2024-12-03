<?php

namespace Database\Seeders;

use App\Models\Technical;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Technical::factory()->count(50)->create();
    }
}
