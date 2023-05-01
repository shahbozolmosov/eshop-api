<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{

    public function index(): JsonResponse
    {
        $result = auth()->user()->favorites->sortDesc();
        $data = FavoriteResource::collection($result);
        return $this->return_success($data);
    }


    public function store(StoreFavoriteRequest $request): JsonResponse
    {
        $user = auth()->user();

        $result = $user->favorites()->where('product_id', $request->product_id)->first();
        if (!empty($result))
            return $this->return_error('You have this favorite product');

        $favorite = $user->favorites()->create([
            'product_id' => $request->product_id
        ]);

        $data = new FavoriteResource($favorite);
        return $this->return_success($data, 'Favorite added!');
    }


    public function show(Favorite $favorite): JsonResponse
    {
        // Validation
        $result = auth()->user()->favorites()->find($favorite->id);
        if (!$result) return $this->return_not_found('No query results for model [App\\Models\\Favorite] ' . $favorite->id);

        return $this->return_success(new FavoriteResource($favorite));
    }


    public function destroy(Favorite $favorite): JsonResponse
    {
        // Validation
        $result = auth()->user()->favorites()->find($favorite->id);
        if (!$result) return $this->return_not_found('No query results for model [App\\Models\\Favorite] ' . $favorite->id);

        $favorite->delete();

        return $this->return_success($favorite, 'Favorite removed!');
    }

}
