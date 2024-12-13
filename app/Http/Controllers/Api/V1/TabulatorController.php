<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tabulator;
use Illuminate\Http\Request;

class TabulatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(Tabulator::orderByDesc('id')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->insertMany($request, new Tabulator);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tabulator $tabulator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tabulator $tabulator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tabulator $tabulator)
    {
        //
    }
}
