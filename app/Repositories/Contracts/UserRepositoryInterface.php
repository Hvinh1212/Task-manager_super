<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Users that can be assigned tasks.
     */
    public function getAssignableUsers(): Collection;
}

