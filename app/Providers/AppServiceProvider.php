<?php

namespace App\Providers;

use App\Facade\Sohoj;
use App\FormFields\RelationShipDropDown;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Browsershot\Browsershot;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sohoj', function () {
            return new Sohoj();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Browsershot::html('Foo')
            ->setNodeBinary('~/nodevenv/home/sohojear/tickets-new/18/bin/node')
            ->setNpmBinary('~/nodevenv/home/sohojear/tickets-new/18/bin/npm');
        Schema::defaultStringLength(191);
        Voyager::addAction(\App\Actions\ReplyAction::class);
        Voyager::addAction(\App\Actions\DuplicateAction::class);
        Voyager::addAction(\App\Actions\AnalyticsAction::class);
        Voyager::addFormField(RelationShipDropDown::class);
    }
}
