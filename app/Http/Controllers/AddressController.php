<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\RegionResource;
use App\Models\Address;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
    public function index(): JsonResponse
    {
        $result = auth()->user()->addresses;
        $data = AddressResource::collection($result);
        return $this->return_success($data);
    }


    public function store(StoreAddressRequest $request): JsonResponse
    {
        // Validation request region with exists region
        $district = District::find($request->district_id);
        $this->checkReigonDistrict($request->region_id, $district->region_id);

        //Save data
        $address = Address::create([
            'region_id' => $request->region_id,
            'district_id' => $request->district_id,
            'street' => $request->street,
            'house' => $request->house,
            'apartment' => $request->apartment,
            'floor' => $request->floor,
        ]);
        // Attach to user
        $userId = auth()->user()->id;
        $address->users()->attach([$userId]);

        $data = new AddressResource($address);
        return $this->return_created_success($data, 'Address');
    }


    public function show(Address $address): JsonResponse
    {
        // Validation check user address
        $result = $this->checkUserAddress($address->id);
        if($result !== 'ok') return $result;

        $data = new AddressResource($result);
        return $this->return_success($data);
    }


    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        // Validation check user address
        $result = $this->checkUserAddress($address->id);
        if($result !== 'ok') return $result;

        // Validation request region with exists region
        $district = District::find($request->district_id);
        $this->checkReigonDistrict($request->region_id, $district->region_id);

        $address->region_id = $request->region_id;
        $address->district_id = $request->district_id;
        $address->street = $request->street;
        $address->house = $request->house;
        $address->apartment = $request->apartment;
        $address->floor = $request->floor;

        $address->save();

        $data = new AddressResource($address);
        return $this->return_success($data);
    }


    public function destroy(Address $address)
    {

    }

    private function checkUserAddress($addressId): JsonResponse|string
    {
        // Validation
        $result = auth()->user()->addresses()->find($addressId);
        if (!$result) return $this->return_not_found('No query results for model [App\\Models\\Address] ' . $addressId);
        return 'ok';
    }

    private function checkReigonDistrict($regionId, $districtId): void
    {
        if ($regionId !== $districtId) {
            throw ValidationException::withMessages([
                "district_id" => 'The selected district id is invalid.',
            ]);
        }
    }
}
