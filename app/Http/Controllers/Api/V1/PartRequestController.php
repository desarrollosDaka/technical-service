<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PartRequest\Status as PartRequestStatus;
use App\Enums\Ticket\Status;
use App\Http\Controllers\Controller;
use App\Jobs\UpdatePartRequest;
use App\Models\PartRequest;
use App\Models\ServiceCall;
use App\Models\TechnicalVisit;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

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
                    'technicalVisit',
                    'media',
                    'ticket'
                ])
                ->where('technical_visit_id', $technicalVisit->getKey())
                ->simplePaginate()
                ->appends($request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'technical_visit_id' => 'required',
            'observation' => 'nullable',
            'meta' => 'nullable|json',
            'date_handed' => 'nullable',
            'name' => 'required|max:255',
            'budget_amount' => 'nullable|numeric',
        ]);

        $technicalVisit = TechnicalVisit::findOrFail($validated['technical_visit_id']);

        Gate::authorize('update', $technicalVisit);

        return $this->success(
            PartRequest::create($validated)
        );
    }

    /**
     * Sincronización de repuesto con backend de Daka
     *
     * @return Response
     */
    public function sync(Request $request): Response
    {
        if ($request->has('callID')) {
            $service_call = ServiceCall::where('callID', $request->callID)->firstOrFail();
            $ticket = $service_call
                ->tickets()
                ->whereNotIn('status', [Status::Cancel, Status::Reject])
                ->with([
                    'partRequest' => fn(HasManyThrough $builder) => $builder->with(['media']),
                    'media' => fn($query) => $query->select(['id', 'file_name', 'model_type', 'model_id', 'collection_name', 'disk']),
                ])
                ->first();

            return $this->success($ticket);
        }

        return $this->success([
            'success' => true,
            'data' =>  PartRequest::where('status', PartRequestStatus::New)
                ->with([
                    'media' => fn($query) => $query
                        ->select(['id', 'file_name', 'model_type', 'model_id', 'collection_name', 'disk']),
                    'ticket' => fn($query) => $query
                        ->select(['tickets.id', 'tickets.status', 'tickets.service_call_id'])
                        ->with([
                            'serviceCall' => fn($query) => $query->select(['service_calls.id', 'service_calls.callID']),
                        ]),
                ])
                ->get()
                ->map(function (PartRequest $partRequest) {
                    return [
                        ...$partRequest->toArray(),
                        'callID' => $partRequest?->ticket?->serviceCall?->callID
                    ];
                }),
        ]);
    }

    /**
     * Sincronización el estatus de repuesto con backend de Daka
     *
     * @return Response
     */
    public function syncStatus(Request $request): Response
    {
        $validated = $request->validate([
            'elements.*.id' => 'required|exists:part_requests,id',
            'elements.*.status' => [
                'required',
                Rule::enum(PartRequestStatus::class),
            ],
            'elements.*.date_handed' => 'nullable|date',
            'elements.*.meta.estimated_handed_date' => 'nullable|date',
            'elements.*.meta.reject_reason' => 'nullable|max:1024',
            'elements.*.meta.approval_information' => 'nullable|max:1024',
            'elements.*.meta.handed_reference' => 'nullable|max:1024',
        ]);

        UpdatePartRequest::dispatch($validated['elements']);

        return $this->success([
            'data' => 'updated',
            'success' => true,
        ]);
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
            'status' => [
                'required',
                Rule::in([
                    PartRequestStatus::New->value,
                    PartRequestStatus::UpdatedBudgetAmount->value,
                    PartRequestStatus::AlreadyBoughtPart->value,
                ])
            ],
            'meta' => 'nullable|json',
            'observation' => 'nullable',
            'budget_amount' => 'nullable',
        ]);

        $partRequest->update($validated);

        return $this->success($partRequest);
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
