<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderGetAllResource;
use App\Http\Resources\OrderGetSingleResource;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(): JsonResponse
    {
        $orders = Order::where('user_id', auth()->id())->orderBy('id', 'DESC')->withCount('products')->get();
        $data = OrderGetAllResource::collection($orders);

        return $this->return_success($data);
    }


    public function store(StoreOrderRequest $request): JsonResponse
    {
        $product = Product::with('stock')->find($request->product_id);
        if ($product->stock->qty_left < $request->qty) {
            return $this->return_not_found('Error: product "' . $product->name . '" not found in stock');
        }

        $currentAddress = Address::with('district', 'region')->find(auth()->user()->default_address);
        if ($currentAddress) {
            $orderAddress = [
                'region' => $currentAddress->region->name,
                'district' => $currentAddress->district->name,
                'street' => $currentAddress->street,
                'house' => $currentAddress->house,
                'apartment' => $currentAddress->apartment,
                'floor' => $currentAddress->floor,
            ];
        } else {
            return $this->return_error('Enter your order address');
        }

        try {
            DB::transaction(function () use ($request, $product, $orderAddress) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total_price' => 0,
                    'address' => json_encode($orderAddress)
                ]);

                $order->products()->attach($product->id, [
                    'qty' => $request->qty,
                    'price' => $product->price
                ]);

                $order->increment('total_price', $request->qty * $product->price);

                Stock::select('qty_left')->where('product_id', $product->id)->decrement('qty_left', $request->qty);

            });

            return $this->return_success('', 'Your order has been accepted success!');
        } catch (Exception) {
            return $this->return_error('Error happened. Try agian or contact us.');
        }

    }


    public function show(Order $order)
    {
        // Validation
        $result = Order::with('products')->where('user_id', auth()->id())->where('id', $order->id)->first();
        if (!$result) return $this->return_not_found('No query results for model [App\\Models\\Order] ' . $order->id);
        $data = new OrderGetSingleResource($result);
        return $this->return_success($data);
    }



    public function destroy(Order $order)
    {
        return $this->return_success($order);
    }
}
