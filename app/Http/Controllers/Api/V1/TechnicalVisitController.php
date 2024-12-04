<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\TechnicalVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TechnicalVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', TechnicalVisit::class);
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
