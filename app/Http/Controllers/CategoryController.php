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


    public function store(StoreCategoryRequest $request)
    {
        //
    }


    public function show(Category $category)
    {
        //
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }


    public function destroy(Category $category)
    {
        //
    }
}
