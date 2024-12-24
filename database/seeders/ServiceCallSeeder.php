<?php

namespace Database\Seeders;

use App\Models\PartRequest;
use App\Models\ServiceCall;
use App\Models\Technical;
use App\Models\TechnicalVisit;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ServiceCallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceCall::factory()
            ->count(10)
            ->create();
    }
}
