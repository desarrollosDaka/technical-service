<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Visit\Reason;
use App\Http\Controllers\Controller;
use App\Http\Requests\TechnicalVisit\StoreRequest;
use App\Http\Requests\TechnicalVisit\UpdateRequest;
use App\Models\TechnicalVisit;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
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
            return $this->success(
                $request->user()->visits()->where('ticket_id', $request->ticket_id)->get()
            );
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
    public function update(UpdateRequest $request, TechnicalVisit $technicalVisit): Response
    {
        Gate::authorize('update', $technicalVisit);

        return $this->success(
            $technicalVisit->update($request->validated())
        );
    }

    /**
     * Reprogram la visita
     *
     * @param Request $request
     * @param TechnicalVisit $technicalVisit
     * @return Response
     */
    public function reprogramming(Request $request, TechnicalVisit $technicalVisit): Response
    {
        $validated = $request->validate([
            'reason' => ['required', Rule::enum(Reason::class)],
            'new_date' => 'required|date',
            'extend_reason' => 'nullable',
        ]);

        Gate::authorize('update', $technicalVisit);

        $previousReprogramming = $technicalVisit->reprogramming;
        $validated['old_date'] = $technicalVisit->visit_date;
        $key = match ((int)$validated['reason']) {
            Reason::ClientCant->value => 'client',
            Reason::TechnicalCant->value => 'technical',
            default => 'other',
        };

        if (isset($previousReprogramming[$key])) {
            $previousReprogramming[$key][] = $validated;
        } else {
            $previousReprogramming[$key] = [$validated];
        }

        $technicalVisit->update([
            'reprogramming' => $previousReprogramming,
            'visit_date' => $validated['new_date'],
        ]);

        return $this->success($technicalVisit);
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
