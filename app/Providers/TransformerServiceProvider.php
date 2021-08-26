<?php

namespace App\Providers;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Support\ServiceProvider;
use Flugg\Responder\Contracts\Transformers\TransformerResolver;

class TransformerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make(TransformerResolver::class)->bind(
            [
            User::class => UserTransformer::class
            ]
        );
    }
}
