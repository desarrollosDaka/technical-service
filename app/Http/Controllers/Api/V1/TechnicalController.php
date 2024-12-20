<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Technical;
use App\Traits\ApiV1Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
            request: $request,
            model: new Technical,
            beforeCreate: function ($element) {
                $GeographicalCoordinates = json_encode($element['GeographicalCoordinates'] ?? []);

                return array_merge($element, [
                    'GeographicalCoordinates' => $GeographicalCoordinates,
                    'Password' => Hash::make(Arr::get($element, 'Phone', 'password')),
                ]);
            },
            getInsertedId: 'ID_user'
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
    public function update(Request $request, Technical $technical) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technical $technical)
    {
        //
    }
}
