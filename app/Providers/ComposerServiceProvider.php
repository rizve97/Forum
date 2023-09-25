<?php

namespace App\Providers;

use App\Channel;
use Illuminate\View\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
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
        view()->composer('layouts.app',function(View $view){
            $channels = Channel::all();
            $view->withChannels($channels);
        });
    }
}
