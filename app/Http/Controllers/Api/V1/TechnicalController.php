<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Technical;
use App\Traits\ApiV1Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class TechnicalController extends Controller
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
        return $this->insertMany(
            $request,
            new Technical,
            beforeCreate: fn($element) => array_merge($element, [
                'GeographicalCoordinates' => json_encode($element['GeographicalCoordinates'] ?? []),
                'Password' => Hash::make(Arr::get($element, 'Phone', 'password')),
            ])
        );
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
