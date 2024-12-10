<?php

namespace Database\Seeders;

use App\Models\ServiceCall;
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
            ->create()
            ->each(function (ServiceCall $serviceCall) {
                $serviceCall->ticket()->create([
                    'title' => Arr::get($serviceCall, 'itemName', $serviceCall->subject),
                    'technical_id' => $serviceCall->ASSIGNED_TECHNICIAN,
                ]);
            });
    }
}
