<?php

namespace App\Policies;

use App\Models\District;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DistrictPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->name === 'admin';
    }


    public function view(User $user, District $district): bool
    {
        return $user->role->name === 'admin';
    }


    public function create(User $user): bool
    {
        return $user->role->name === 'admin';
    }


    public function update(User $user, District $district): bool
    {
        return $user->role->name === 'admin';
    }


    public function delete(User $user, District $district): bool
    {
        return $user->role->name === 'admin';
    }


    public function restore(User $user, District $district): bool
    {
        return $user->role->name === 'admin';
    }


    public function forceDelete(User $user, District $district): bool
    {
        return $user->role->name === 'admin';
    }
}
