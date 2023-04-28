<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\JsonResponse;

class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Region::class, 'region');
    }

    public function index(): JsonResponse
    {
        return $this->return_success(RegionResource::collection(Region::all()));
    }


    public function store(StoreRegionRequest $request)
    {
        $region = Region::create([
            'name' => $request->name,
        ]);

        return $this->return_created_success($region, 'Region');
    }


    public function show(Region $region)
    {
        return $this->return_success(new RegionResource($region));
    }


    public function update(UpdateRegionRequest $request, Region $region): JsonResponse
    {
        $region->update([
            'name' => $request->name
        ]);

        return $this->return_success($region, 'Region updated!');
    }


    public function destroy(Region $region): JsonResponse
    {
        $region->delete();
        return $this->return_success($region, 'Region removed!');
    }
}
