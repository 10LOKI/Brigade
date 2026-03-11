<?php
// app/Policies/CategoriePolicy.php

namespace App\Policies;

use App\Models\Categorie;
use App\Models\Category;
use App\Models\User;

class CategoriePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Category $categorie): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Category $categorie): bool
    {
        return $user->role === 'admin' 
            && $user->restaurant_id === $categorie->restaurant_id;
    }

    public function delete(User $user, Category $categorie): bool
    {
        return $user->role === 'admin' 
            && $user->restaurant_id === $categorie->restaurant_id;
    }
}