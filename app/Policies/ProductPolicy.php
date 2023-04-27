<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->name === 'admin';
    }


    public function view(User $user, Product $product): bool
    {
        return $user->role->name === 'admin';
    }


    public function create(User $user): bool
    {
        return $user->role->name === 'admin';
    }


    public function update(User $user, Product $product): bool
    {
        return $user->role->name === 'admin';
    }


    public function delete(User $user, Product $product): bool
    {
        return $user->role->name === 'admin';
    }


    public function restore(User $user, Product $product): bool
    {
        return $user->role->name === 'admin';
    }


    public function forceDelete(User $user, Product $product): bool
    {
        return $user->role->name === 'admin';
    }
}
