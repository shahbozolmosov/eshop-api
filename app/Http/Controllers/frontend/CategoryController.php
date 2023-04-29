<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\QueryPaginationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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

    public function show(Category $category): JsonResponse
    {
        return $this->return_success(new CategoryResource($category));
    }
}
