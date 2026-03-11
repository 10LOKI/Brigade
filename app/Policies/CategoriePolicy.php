<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoriePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Category $category): bool
    {
        return $user->role === 'admin' && $user->id === $category->user_id;
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->role === 'admin' && $user->id === $category->user_id;
    }
}