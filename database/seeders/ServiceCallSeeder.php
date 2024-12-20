<?php

namespace Database\Seeders;

use App\Models\ServiceCall;
use App\Models\Technical;
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
                $serviceCall->tickets()->create([
                    'title' => Arr::get($serviceCall, 'itemName', $serviceCall->subject),
                    'customer_name' => $serviceCall->custmrName,
                    'technical_id' => Technical::where('ID_user', $serviceCall->ASSIGNED_TECHNICIAN)
                        ->first()
                        ->getKey(),
                ]);
            });
    }
}
