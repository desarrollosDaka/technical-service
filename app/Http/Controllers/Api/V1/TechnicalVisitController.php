<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiV1Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\TechnicalVisit\StoreRequest;
use App\Http\Requests\TechnicalVisit\UpdateRequest;
use App\Models\TechnicalVisit;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class TechnicalVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $request->validate([
            'ticket_id' => 'nullable',
        ]);

        if (!$request->has('ticket_id')) {
            return $this->success($request->user()->visits);
        }

        $ticket = Ticket::where('id', $request->ticket_id)
            ->where('technical_id', $request->user()->getKey())
            ->firstOrFail();

        Gate::authorize('viewAny', TechnicalVisit::class);

        return $this->success(
            QueryBuilder::for(TechnicalVisit::class)
                ->allowedFilters(['visit_date'])
                ->allowedSorts(['visit_date', 'created_at'])
                ->defaultSort('-created_at')
                ->allowedIncludes(['ticket'])
                ->where('ticket_id', $ticket->getKey())
                ->simplePaginate()
                ->appends($request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): Response
    {
        return $this->success(
            TechnicalVisit::create([
                ...$request->validated(),
                'technical_id' => $request->user()->getKey(),
            ]),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(TechnicalVisit $technicalVisit): Response
    {
        Gate::authorize('view', $technicalVisit);
        return $this->success(
            QueryBuilder::for(TechnicalVisit::class)
                ->allowedIncludes(['ticket'])
                ->find($technicalVisit->getKey())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, TechnicalVisit $technicalVisit)
    {
        return $this->success(
            $technicalVisit->update($request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechnicalVisit $technicalVisit)
    {
        Gate::authorize('delete', $technicalVisit);
        $technicalVisit->delete();
        return $this->success(['data' => 'deleted']);
    }
}
