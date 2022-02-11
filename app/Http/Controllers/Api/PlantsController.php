<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantRequest;
use App\Http\Resources\PlantResource;
use App\Models\Plant;

class PlantsController extends Controller
{
    public function index()
    {
        $plans = Plant::all();
        return PlantResource::collection($plans);
    }


    public function store(PlantRequest $request)
    {
        return new PlantResource($request->persist());
    }
}
