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
        // Validation
        $district = District::find($request->district_id);
        if ($district->region_id !== $request->region_id) {
            throw ValidationException::withMessages([
                "district_id" => 'The selected district id is invalid.',
            ]);
        }

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
        // Validation
        $result = auth()->user()->addresses()->find($address->id);
        if (!$result) return $this->return_not_found('No query results for model [App\\Models\\Address] ' . $address->id);

        $data = new AddressResource($result);
        return $this->return_success($data);
    }


    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        // Validation
        $result = auth()->user()->addresses()->find($address->id);
        if (!$result) return $this->return_not_found('No query results for model [App\\Models\\Address] ' . $address->id);

        $district = District::find($request->district_id);
        if ($district->region_id !== $request->region_id) {
            throw ValidationException::withMessages([
                "district_id" => 'The selected district id is invalid.',
            ]);
        }

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
        //
    }
}
