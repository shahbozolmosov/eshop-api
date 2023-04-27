<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Image;
use App\Services\QueryPaginationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Category::class, 'category');
    }

    public function index(Request $request, QueryPaginationService $queryPaginationService): JsonResponse
    {
        $result = $queryPaginationService->getData(Category::query(), $request);

        $data = CategoryResource::collection($result['data']);

        return $this->return_success_pagin(
            $data,
            $result['total'],
            $result['page'],
            $result['perPage'],
        );
    }


    public function store(StoreCategoryRequest $request): JsonResponse
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('category-images');
        }

        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id ?? null
        ]);

        if (isset($path)) {
            $image = new Image(['url' => $path]);
            $category->images()->save($image);
        }

        $data = new CategoryResource($category);
        return $this->return_created_success($data, 'Category');
    }


    public function show(Category $category): JsonResponse
    {
        return $this->return_success(new CategoryResource($category));
    }


    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        if ($request->hasFile('image')) {
            if (isset($category->images)) {
                Storage::delete($category->images[0]->url);
            }

            $path = $request->file('image')->store('category-images');
        }

        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id ?? $category->parent_id
        ]);

        if (isset($path)) {
            $category->images()->delete();
            $image = new Image(['url' => $path]);
            $category->images()->save($image);
        }

        return $this->return_success([
            'id' => $category->id,
            'name' => $category->name,
            'image' => $path??'',
            'parent_id' => $category->parent_id ?? null,
            'created_at' => $category->created_at->format('d/m/Y'),
        ], 'Category update!');
    }


    public function destroy(Category $category): JsonResponse
    {
        if (isset($category->images)) {
            Storage::delete($category->images[0]->url);
        }
        $category->delete();
        $category->images()->delete();

        return $this->return_success([
            "id" => $category->id,
            "name" => $category->name,
        ], 'Category removed!');
    }
}
