<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Stock;
use App\Services\QueryPaginationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Product::class, 'product');
    }

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
        $product = new Product();

        $resultPath = [];
        //Upload images to store
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $resultPath[] = $image->store('products-images');
            }
        }
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        // Save value for stock
        $stock = new Stock();
        $stock->qty_left = $request->qty_left;
        $product->stock()->save($stock);

        //Save images path to database
        foreach ($resultPath as $path) {
            $image = new Image(['url' => $path]);
            $product->images()->save($image);
        }
        $data = new ProductResource($product);
        return $this->return_created_success($data, 'Product');
    }


    public function show(Product $product): JsonResponse
    {
        return $this->return_success(new ProductResource($product));
    }


    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $resultPath = [];
        // Upload images to storage
        if ($request->hasFile('images')) {
            // Remove old images
            if (isset($product->images)) {
                foreach ($product->images as $image) {
                    Storage::delete($image->url);
                }
                $product->images()->delete();
            }

            foreach ($request->images as $image) {
                $resultPath[] = $image->store('products-images');
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);
        $product->stock()->update(['qty_left' => $request->qty_left]);

        //Save images path to database
        foreach ($resultPath as $path) {
            $image = new Image(['url' => $path]);
            $product->images()->save($image);
        }

        return $this->return_success([
            'id' => $product->id,
            'category' => new CategoryResource($product->category),
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'qty_left' => $product->stock->qty_left,
            'images' => $resultPath,
            'created_at' => $product->created_at->format('d/m/Y'),
        ], 'Product update!');
    }


    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        if (isset($product->images)) {
            foreach ($product->images as $image) {
                Storage::delete($image->url);
            }
        }

        $data = new ProductResource($product);
        return $this->return_success($data, 'Product removed!');
    }
}
