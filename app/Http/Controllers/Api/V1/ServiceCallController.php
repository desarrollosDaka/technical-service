<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Ticket\Status as TicketStatus;
use App\Http\Controllers\Controller;
use App\Jobs\CreateTickets;
use App\Models\ServiceCall;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
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
     * Sincronizar las service call
     *
     * @param Request $request
     * @return Response
     */
    public function sync(Request $request)
    {
        return $this->success(
            QueryBuilder::for(ServiceCall::class)
                ->defaultSort('-id')
                ->allowedSorts(['id', 'updated_at'])
                ->when(
                    $request->has('app_status'),
                    fn($query) => $query->where('app_status', $request->app_status)
                )
                ->when(
                    $request->get('app_status', 0) === (string) TicketStatus::Reject->value,
                    fn($query) => $query->with([
                        'technicians' => fn($query) => $query->select(['technicals.id', 'technicals.User_name', 'technicals.Email', 'technicals.ID_user'])
                    ])
                )
                ->whereBetween('updated_at', [now()->subDays(15), now()])
                ->get()
        );
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
