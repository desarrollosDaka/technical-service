<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PartRequest\Status as PartRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\PartRequest;
use App\Models\TechnicalVisit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PartRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'technical_visit_id' => 'required',
        ]);

        $technicalVisit = TechnicalVisit::findOrFail($validated['technical_visit_id']);

        Gate::authorize('update', $technicalVisit);

        return $this->success(
            QueryBuilder::for(PartRequest::class)
                ->defaultSort('-id')
                ->allowedFilters([
                    AllowedFilter::exact('status'),
                ])
                ->allowedIncludes([
                    'tabulator',
                    'technicalVisit'
                ])
                ->where('technical_visit_id', $technicalVisit->getKey())
                ->simplePaginate()
                ->appends($request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tabulator_id' => 'required|exists:tabulators,id',
            'technical_visit_id' => 'required',
            'observation' => 'nullable',
            'meta' => 'nullable',
        ]);

        $technicalVisit = TechnicalVisit::findOrFail($validated['technical_visit_id']);

        Gate::authorize('update', $technicalVisit);

        return $this->success(
            PartRequest::create($validated)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(PartRequest $partRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PartRequest $partRequest)
    {
        Gate::authorize('update', $partRequest->technicalVisit);
        $validated = $request->validate([
            'meta' => 'nullable',
            'observation' => 'nullable',
        ]);

        return $this->success($partRequest->update($validated));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PartRequest $partRequest)
    {
        Gate::authorize('update', $partRequest->technicalVisit);

        return $this->success($partRequest->delete());
    }
}
