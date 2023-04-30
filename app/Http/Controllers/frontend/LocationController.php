<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\RegionResource;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LocationController extends Controller
{
    public function regions(): JsonResponse
    {
        $data = RegionResource::collection(Region::all());
        return $this->return_success($data);
    }


    public function districts(Request $request): JsonResponse
    {
        if($regionId = $request->input('regionId')){
            $data = DistrictResource::collection(District::where('region_id', $regionId)->get());
            return $this->return_success($data);
        }
        throw ValidationException::withMessages([
            "regionId" => 'RegionId required'
        ]);
    }
}
