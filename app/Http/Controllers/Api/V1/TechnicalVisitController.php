<?php

namespace App\Http\Controllers\Api\v1;

use App\ApiV1Responser;
use App\Http\Controllers\Controller;
use App\Models\TechnicalVisit;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class TechnicalVisitController extends Controller
{
    use ApiV1Responser;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required',
        ]);

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TechnicalVisit $technicalVisit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechnicalVisit $technicalVisit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechnicalVisit $technicalVisit)
    {
        //
    }
}
