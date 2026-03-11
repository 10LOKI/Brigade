<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Plat;
use App\Policies\CategoriePolicy;
use App\Policies\PlatPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Category::class, CategoriePolicy::class);
        Gate::policy(Plat::class, PlatPolicy::class);
    }
}
