<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\QueryPaginationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id??null
        ]);

        $data = new CategoryResource($category);
        return $this->return_created_success($data, 'Category');
    }


    public function show(Category $category): JsonResponse
    {
        return $this->return_success(new CategoryResource($category));
    }


    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id??$category->parent_id
        ]);

        $data = new CategoryResource($category);
        return $this->return_success($data, 'Category update!');
    }


    public function destroy(Category $category)
    {
        //
    }
}
