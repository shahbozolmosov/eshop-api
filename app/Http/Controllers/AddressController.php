<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{

    public function index(): JsonResponse
    {
        $result = auth()->user()->addresses;
        $data = AddressResource::collection($result);
        return $this->return_success($data);
    }


    public function store(StoreAddressRequest $request)
    {
        //
    }


    public function show(Address $address): JsonResponse
    {
        $result = auth()->user()->addresses()->find($address->id);
        if(!$result) return $this->return_not_found('No query results for model [App\\Models\\Address] '.$address->id);

        $data = new AddressResource($result);
        return $this->return_success($data);
    }


    public function update(UpdateAddressRequest $request, Address $address)
    {
        //
    }


    public function destroy(Address $address)
    {
        //
    }
}
