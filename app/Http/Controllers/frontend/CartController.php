<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{

    public function index(): JsonResponse
    {
        $result = auth()->user()->carts->sortDesc();
        $data = CartResource::collection($result);

        return $this->return_success($data);
    }


    public function store(StoreCartRequest $request): JsonResponse
    {
        $user = auth()->user();
        $result = $user->carts()->where('product_id', $request->product_id)->first();

        if (empty($result) && $request->qty === 'increment') { // New product add to cart
            $result = $user->carts()->create([
                'product_id' => $request->product_id,
                'qty' => 1
            ]);

            $data = new CartResource($result);
            return $this->return_success($data, 'Product added to cart!');
        } else if (!empty($result)) { // exist product qty
            // product's stock quantity_left
            $qty_left = $result->product->stock->qty_left;
            if ($request->qty === 'increment') { // qty increment
                if ($qty_left > $result->qty) {
                    $result->update([
                        'qty' => $result->qty + 1
                    ]);
                }
            } else if ($request->qty === 'decrement') {// qty decrement
                if ($result->qty > $qty_left) {
                    $result->update([
                        'qty' => $result->qty - 1
                    ]);
                }
            }

            $data = new CartResource($result);
            return $this->return_success($data);
        }

        return $this->return_error([
            "qty" => "Th qty must be increment"
        ]);
    }


    public function show(Cart $cart): JsonResponse
    {
        $shopCart = auth()->user()->shoppingCarts()->find($cart->id);
        if (!$shopCart) return $this->return_not_found('No query results for model [App\\Models\\ShoppingCart] ' . $cart->id);

        $data = new CartResource($shopCart);
        return $this->return_success($data);
    }


    public function destroy(Cart $cart): JsonResponse
    {
        $shopCart = auth()->user()->carts()->find($cart->id);
        if (!$shopCart) return $this->return_not_found('No query results for model [App\\Models\\ShoppingCart] ' . $cart->id);

        $shopCart->delete();

        $data = new CartResource($shopCart);
        return $this->return_success($data, 'Cart removed!');
    }
}
