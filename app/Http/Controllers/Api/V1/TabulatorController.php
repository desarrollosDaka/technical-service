<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tabulator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class TabulatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->success(
            QueryBuilder::for(Tabulator::class)
                ->defaultSort('-id')
                ->allowedFilters([
                    'n',
                    'linea',
                    'gama',
                    'producto',
                    'familia',
                    'repuestos',
                ])
                ->simplePaginate($request->get('perPage', 15))
                ->appends($request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        return $this->insertMany(
            request: $request,
            model: new Tabulator,
            getInsertedId: 'n',
        );
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
