<?php

namespace Database\Seeders;

use App\Models\ServiceCall;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceCall::factory()->count(50)->create();
    }
}
