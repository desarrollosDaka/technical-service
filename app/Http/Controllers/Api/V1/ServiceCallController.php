<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\CreateTickets;
use App\Models\ServiceCall;
use App\Models\Ticket;
use App\Traits\ApiV1Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ServiceCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        return $this->insertMany(
            $request,
            new ServiceCall,
            beforeCreate: fn($element) => array_merge($element, [
                'CLIENT_COORDINATE' => json_encode($element['CLIENT_COORDINATE'] ?? []),
            ]),
            afterCreate: function ($inserts): void {
                CreateTickets::dispatch($inserts);
            },
            getInsertedId: 'callID',
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceCall $serviceCall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceCall $serviceCall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCall $serviceCall)
    {
        //
    }
}
