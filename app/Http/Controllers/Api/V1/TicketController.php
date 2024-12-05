<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiV1Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreRequest as StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateRequest;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
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
        Gate::authorize('viewAny', Ticket::class);
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
                ->allowedIncludes([
                    'technical',
                    'serviceCall',
                    'visits',
                    AllowedInclude::callback('media', function (MorphMany $query) {
                        if (request()->has('collection_name')) {
                            return $query->where('collection_name', request('collection_name'));
                        }
                        return $query;
                    }),
                ])
                ->defaultSort('-created_at')
                ->where('technical_id', $request->user()->getKey())
                ->simplePaginate()
                ->appends($request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request): Response
    {
        return $this->success(
            $request->user()->tickets()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): Response
    {
        Gate::authorize('view', $ticket);
        return $this->success(
            QueryBuilder::for(Ticket::class)
                ->allowedIncludes(['technical', 'serviceCall', 'visits'])
                ->find($ticket->getKey())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Ticket $ticket): Response
    {
        return $this->success(
            $ticket->update($request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): Response
    {
        Gate::authorize('delete', $ticket);
        return $this->success($ticket->delete());
    }
}
