<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\QueryPaginationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    public function index(Request $request, QueryPaginationService $queryPaginationService): JsonResponse
    {
        $result = $queryPaginationService->getData(Product::query(), $request);

        $data = ProductResource::collection($result['data']);

        return $this->return_success_pagin(
            $data,
            $result['total'],
            $result['page'],
            $result['perPage']
        );
    }


    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create([
            'category_id' => $request->category_id,
            'name'=> $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        return $this->return_created_success($product, 'Product');
    }


    public function show(Product $product): JsonResponse
    {
        return $this->return_success(new ProductResource($product));
    }


    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update([
            'category_id' => $request->category_id,
            'name'=> $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        $data = new ProductResource($product);
        return $this->return_success($data, 'Product update!');
    }


    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        $data = new ProductResource($product);
        return $this->return_success($data, 'Product removed!');
    }
}
