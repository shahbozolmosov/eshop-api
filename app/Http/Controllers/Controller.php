<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function return_success_pagin(mixed $data, int $total, mixed $page, mixed $perPage): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'lastPage' => ceil($total / $perPage),
        ]);
    }

    public function return_created_success(mixed $data, string $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            "message" => $message . ' created!',
            "data" => $data,
        ], 201);
    }

    public function return_success(mixed $data, string $message = ''): JsonResponse
    {
        return response()->json([
            'success' => true,
            "message" => $message,
            "data" => $data
        ]);
    }

    public function return_error(string $message = '')
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 400);
    }

    public function return_not_found(string $message = ''): JsonResponse
    {
        return response()->json([
            'success' => false,
            "message" => $message,
        ], 404);
    }
}
