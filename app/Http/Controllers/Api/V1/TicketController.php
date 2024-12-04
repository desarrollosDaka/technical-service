<?php

namespace App\Http\Controllers\Api\V1;

use App\ApiV1Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreRequest as StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    use ApiV1Responser;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return $this->success(
            QueryBuilder::for(Ticket::class)
                ->allowedFilters([
                    'title',
                    'customer_name',
                    AllowedFilter::exact('status'),
                ])
                ->allowedSorts([
                    'title',
                    'created_at',
                    'diagnosis_date',
                    'solution_date',
                ])
                ->defaultSort('-created_at')
                ->simplePaginate()
                ->appends($request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        return $this->success(
            $request->user()->tickets()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return $ticket;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
