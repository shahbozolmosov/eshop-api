<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use App\Http\Resources\DistrictResoure;
use App\Models\District;
use Illuminate\Http\JsonResponse;

class DistrictController extends Controller
{

    public function index(): JsonResponse
    {
        return $this->return_success(DistrictResoure::collection(District::all()));
    }


    public function store(StoreDistrictRequest $request): JsonResponse
    {
        $district = District::create([
            'region_id' => $request->region_id,
            'name' => $request->name,
        ]);

        return $this->return_created_success($district, 'District');
    }


    public function show(District $district): JsonResponse
    {
        return $this->return_success(new DistrictResoure($district));
    }


    public function update(UpdateDistrictRequest $request, District $district): JsonResponse
    {
        $district->update([
            'region_id' => $request->region_id,
            'name' => $request->name,
        ]);

        return $this->return_success($district, 'District updated!');
    }


    public function destroy(District $district): JsonResponse
    {
        $district->delete();

        return $this->return_success($district, 'District removed!');
    }
}
