<?php

namespace Database\Seeders;

use App\Models\TechnicalVisit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicalVisitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TechnicalVisit::factory()
            ->count(30)
            ->create();
    }
}
