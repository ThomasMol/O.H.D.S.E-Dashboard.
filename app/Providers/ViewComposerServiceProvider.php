<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot(){
        view()->composer("*","App\Http\View\ViewComposer");
    }

    public function register()
    {
        $this->app->singleton(\App\Http\View\ViewComposer::class);
    }
}
