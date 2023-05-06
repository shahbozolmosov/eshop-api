<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Stock;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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
                if ($result->qty > 1) {
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
        //Validation
        $shopCart = auth()->user()->shoppingCarts()->find($cart->id);
        if (!$shopCart) return $this->return_not_found('No query results for model [App\\Models\\ShoppingCart] ' . $cart->id);

        $data = new CartResource($shopCart);
        return $this->return_success($data);
    }


    public function destroy(Cart $cart): JsonResponse
    {
        //Validation
        $shopCart = auth()->user()->carts()->find($cart->id);
        if (!$shopCart) return $this->return_not_found('No query results for model [App\\Models\\ShoppingCart] ' . $cart->id);

        $shopCart->delete();

        $data = new CartResource($shopCart);
        return $this->return_success($data, 'Cart removed!');
    }


    public function checkout(): JsonResponse
    {
        $cart = Cart::with('product')->where('user_id', auth()->id())->get();
        if ($cart->isEmpty()) {
            return $this->return_not_found('Error: Your shopping cart is empty');
        }

        $productStock = Stock::select('product_id', 'qty_left')
            ->whereIn('product_id', $cart->pluck('product_id'))
            ->pluck('qty_left', 'product_id');
        foreach ($cart as $cartProduct) {
            if (!isset($productStock[$cartProduct->product_id]) || $productStock[$cartProduct->product_id] < $cartProduct->qty) {
                return $this->return_not_found('Error: product "' . $cartProduct->product->name . '" not found in stock');
            }
        }

        $currentAddress = Address::with('district', 'region')->find(auth()->user()->default_address);
        $orderAddress = [];
        if ($currentAddress) {
            $orderAddress = [
                'region' => $currentAddress->region->name,
                'district' => $currentAddress->district->name,
                'street' => $currentAddress->street,
                'house' => $currentAddress->house,
                'apartment' => $currentAddress->apartment,
                'floor' => $currentAddress->floor,
            ];
        }else {
            return $this->return_error('Enter your order address');
        }

        try {
            Db::transaction(function () use ($cart, $orderAddress) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total_price' => 0,
                    'address' => json_encode($orderAddress)
                ]);

                foreach ($cart as $cartProduct) {
                    $order->products()->attach($cartProduct->product_id, [
                        'qty' => $cartProduct->qty,
                        'price' => $cartProduct->product->price
                    ]);

                    $order->increment('total_price', $cartProduct->qty * $cartProduct->product->price);

                    Stock::where('product_id', $cartProduct->product_id)->decrement('qty_left', $cartProduct->qty);
                }

                Cart::where('user_id', auth()->id())->delete();
            });

            return $this->return_success('', 'Checkout success!');
        } catch (Exception) {
            return $this->return_error('Error happened. Try agian or contact us.');
        }
    }
}
