<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Traits\BaseRepositoryTrait;

class UserRepository implements UserRepositoryInterface
{
    use BaseRepositoryTrait;

    public function __construct()
    {
        $this->initializeRepository();
    }

    protected function model(): string
    {
        return User::class;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->newQuery()->where('email', $email)->first();
    }

    public function existsByEmail(string $email): bool
    {
        return $this->model->newQuery()->where('email', $email)->exists();
    }
}
