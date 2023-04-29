<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
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

    public function show(Product $product): JsonResponse
    {
        return $this->return_success(new ProductResource($product));
    }
}
