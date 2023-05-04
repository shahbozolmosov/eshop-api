<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    public function index(): JsonResponse
    {
        $orders = Order::with('products')->where('user_id', auth()->id())->get();
        $data = OrderResource::collection($orders);

        return $this->return_success($data);
    }


    public function store(StoreOrderRequest $request)
    {
        //
    }


    public function show(Order $order)
    {
        //
    }


    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        //
    }
}
