<?php

namespace App\Http\Controllers\Api\V1;

use App\ApiV1Responser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreRequest as StoreTicketRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    use ApiV1Responser;

    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $request->user()->tickets()->create($request->validated());
        return $this->success($request->all(), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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