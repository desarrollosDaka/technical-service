<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Technical;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
