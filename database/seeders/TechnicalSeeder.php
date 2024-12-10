<?php

namespace Database\Seeders;

use App\Models\ServiceCall;
use App\Models\Technical;
use App\Models\TechnicalVisit;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Technical::factory()
            ->count(20)
            ->create();
    }
}
