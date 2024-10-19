<?php

namespace App\Providers;

use App\Facade\Sohoj;
use App\FormFields\RelationShipDropDown;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Browsershot\Browsershot;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

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

        Paginator::useBootstrapThree();
        Schema::defaultStringLength(191);
        // Voyager::addAction(\App\Actions\ReplyAction::class);
        Voyager::addAction(\App\Actions\DuplicateAction::class);
        Voyager::addAction(\App\Actions\AnalyticsAction::class);
        Voyager::addAction(\App\Actions\AddExtraAction::class);
        Voyager::addAction(\App\Actions\StaffReportAction::class);
        Voyager::addAction(\App\Actions\InviteLinkAction::class);
        Voyager::addAction(\App\Actions\GeneratePhysicalTicketAction::class);
        Voyager::addFormField(\App\FormFields\ArrayDateField::class);
    }
}
