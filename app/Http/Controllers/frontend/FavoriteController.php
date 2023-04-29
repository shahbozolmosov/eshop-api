<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{

    public function index(): JsonResponse
    {
        $result = auth()->user()->favorites;
        $data = FavoriteResource::collection($result);
        return $this->return_success($data);
    }


    public function store(StoreFavoriteRequest $request): JsonResponse
    {
        $user = auth()->user();

        $result = $user->favorites()->where('product_id', $request->product_id)->first();
        if(!empty($result))
            return $this->return_error('You have this favorite product');

        $favorite = $user->favorites()->create([
            'product_id' => $request->product_id
        ]);

        $data = new FavoriteResource($favorite);
        return $this->return_success($data, 'Favorite added!');
    }


    public function show(Favorite $favorite)
    {
        //
    }


    public function update(UpdateFavoriteRequest $request, Favorite $favorite)
    {
        //
    }


    public function destroy(Favorite $favorite)
    {
        //
    }
}
