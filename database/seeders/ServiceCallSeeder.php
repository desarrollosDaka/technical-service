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
            ->create()
            ->each(function (ServiceCall $serviceCall) {
                $serviceCall
                    ->tickets()
                    ->create([
                        'title' => Arr::get($serviceCall, 'itemName', $serviceCall->subject),
                        'customer_name' => $serviceCall->custmrName,
                        'technical_id' => Technical::where('ID_user', $serviceCall->ASSIGNED_TECHNICIAN)
                            ->first()
                            ->getKey(),
                    ])
                    ->each(function (Ticket $ticket) {
                        TechnicalVisit::factory()
                            ->count(10)
                            ->create(['ticket_id' => $ticket->id])
                            ->each(function (TechnicalVisit $visit) {
                                // Crear solicitudes de partes para cada visita técnica
                                PartRequest::factory()
                                    ->count(10)
                                    ->create([
                                        'technical_visit_id' => $visit->id
                                    ]);
                            });
                    });
            });
    }
}
