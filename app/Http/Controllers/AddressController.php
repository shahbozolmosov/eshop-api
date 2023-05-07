<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\District;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
    private int $maxUserAddressCount = 100;

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

        //Get user all address count
        $addressCount = auth()->user()->addresses()->count();

        if ($addressCount >= $this->maxUserAddressCount) {
            return $this->return_error(
                'The count of addresses is more than ' . $this->maxUserAddressCount . '. Only ' . $this->maxUserAddressCount . ' addresses are allowed!'
            );
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
        $userId = auth()->id();
        $address->users()->attach([$userId], [
            'is_default' => $addressCount === 0
        ]);

        $data = new AddressResource($address);
        return $this->return_created_success($data, 'Address');
    }


    public function show(Address $address): JsonResponse
    {
        // Validation check user address
        $result = auth()->user()->addresses()->find($address->id);
        if (!$result) return $this->return_not_found('No query results for model [App\\Models\\Address] ' . $address->id);

        $data = new AddressResource($result);
        return $this->return_success($data);
    }


    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        // Validation check user address
        $result = auth()->user()->addresses()->find($address->id);
        if (!$result) return $this->return_not_found('No query results for model [App\\Models\\Address] ' . $address->id);

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
        return $this->return_success($data, 'Address updated!');
    }


    public function destroy(Address $address): JsonResponse
    {
        // Validation check user address
        $result = auth()->user()->addresses()->find($address->id);
        if (!$result) return $this->return_not_found('No query results for model [App\\Models\\Address] ' . $address->id);

        $address->delete();
        $address->users()->detach();

        $data = new AddressResource($address);
        return $this->return_success($data, 'Address removed!');
    }

    public function changeCurrentAddress(Request $request): JsonResponse
    {
        // Validation check exits address_id
        $request->validate([
            'address_id' => 'required'
        ]);

        // Validation check user address
        $address = auth()->user()->addresses->find($request->address_id);
        if (!$address) return $this->return_not_found('No query results for model [App\\Models\\Address] ' . $request->address_id);

        auth()->user()
            ->addresses()
            ->wherePivot('is_default', true)
            ->update(['is_default' => false]);

        $address->users()->updateExistingPivot(auth()->id(), [
            'is_default' => true
        ]);

        return $this->return_success([
            'default_address_id' => $address->id
        ], 'Current address changed!');
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
