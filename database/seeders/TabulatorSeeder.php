<?php

namespace Database\Seeders;

use App\Models\Tabulator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabulatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tabulator::factory()->count(50)->create();
    }
}
