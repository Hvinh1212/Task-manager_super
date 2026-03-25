<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getAssignableUsers(): Collection
    {
        return User::query()
            ->where('role', 'user')
            ->orderBy('name')
            ->get();
    }
}

