<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use App\Http\Resources\DistrictResource;
use App\Models\District;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(District::class, 'district');
    }

    public function index(Request $request): JsonResponse
    {
        if ($regionId = $request->input('regionId')) {
            $data = DistrictResource::collection(District::where('region_id', $regionId)->get());
            return $this->return_success([
                'districts' => $data,
                'region_id' => $regionId
            ]);
        }

        return $this->return_success(DistrictResource::collection(District::all()));
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
        return $this->return_success(new DistrictResource($district));
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
