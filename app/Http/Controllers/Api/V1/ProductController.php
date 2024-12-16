<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Technical;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return $this->success(
            QueryBuilder::for(Product::class)
                ->defaultSort('-id')
                ->allowedFilters([
                    'ItemCode',
                    'ItemName',
                    'CodeBars',
                    'ItmsGrpNam',
                ])
                ->simplePaginate()
                ->appends($request->query())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        return $this->insertMany($request, new Product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Technical $technical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technical $technical)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technical $technical)
    {
        //
    }
}
