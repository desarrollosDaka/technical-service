<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreRequest as StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateRequest;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Ticket::class);
        return $this->externalGet($request, $request->user()->getKey());
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
        return $this->externalFindGet($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Ticket $ticket): Response
    {
        $ticket->update($request->validated());

        return $this->success($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): Response
    {
        Gate::authorize('delete', $ticket);
        return $this->success($ticket->delete());
    }

    /**
     * API external para el backoffice de ATC
     *
     * @param Request $request
     * @return Response
     */
    public function externalGet(Request $request, ?int $technical_id = null): Response
    {
        return $this->success(
            QueryBuilder::for(Ticket::class)
                ->allowedFilters([
                    'title',
                    'customer_name',
                    AllowedFilter::exact('status'),
                    AllowedFilter::callback('callID', function (Builder $query, $value) {
                        return $query->whereHas(
                            'serviceCall',
                            fn(Builder $query) => $query->where('callID', $value)
                        );
                    })
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
                    'partRequest',
                    AllowedInclude::callback('media', function (MorphMany $query) {
                        if (request()->has('collection_name')) {
                            return $query->where('collection_name', request('collection_name'));
                        }
                        return $query;
                    }),
                ])
                ->defaultSort('-updated_at')
                ->when($technical_id, fn(Builder $query) => $query->where('technical_id', $technical_id))
                ->simplePaginate($request->get('perPage', 15))
                ->appends($request->query())
        );
    }

    /**
     * Hacer búsqueda de 1 elementos
     *
     * @param Ticket $ticket
     * @return Response
     */
    public function externalFindGet(Ticket $ticket): Response
    {
        return $this->success(
            QueryBuilder::for(Ticket::class)
                ->allowedIncludes([
                    'technical',
                    'serviceCall',
                    'visits',
                    'partRequest',
                    'comments',
                    AllowedInclude::callback('media', function (MorphMany $query) {
                        if (request()->has('collection_name')) {
                            return $query->where('collection_name', request('collection_name'));
                        }
                        return $query;
                    }),
                ])
                ->findOrFail($ticket->getKey())
        );
    }
}
