<?php

namespace App\Policies;

use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->name === 'admin';
    }


    public function view(User $user, Region $region): bool
    {
        return $user->role->name === 'admin';
    }


    public function create(User $user): bool
    {
        return $user->role->name === 'admin';
    }


    public function update(User $user, Region $region): bool
    {
        return $user->role->name === 'admin';
    }


    public function delete(User $user, Region $region): bool
    {
        return $user->role->name === 'admin';
    }


    public function restore(User $user, Region $region): bool
    {
        return $user->role->name === 'admin';
    }


    public function forceDelete(User $user, Region $region): bool
    {
        return $user->role->name === 'admin';
    }
}
