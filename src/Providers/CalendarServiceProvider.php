<?php

namespace Platform\Plugins\Calendar\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Console\Scheduling\Schedule;
use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\DashboardMenuItem;

class CalendarServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'calendar');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'calendar');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Platform\Plugins\Calendar\Console\Commands\SendTaskReminders::class,
            ]);
        }

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('calendar:send-reminders')->daily();
        });

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-plugins-calendar')
                        ->priority(99)
                        ->name('Calendar')
                        ->icon('ti ti-calendar')
                        ->route('admin.calendar.index')
                );
        });
    }
} 