<?php

namespace Code\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Code\Services\MailService;
use Code\Services\NotiService;
use Code\Services\WebService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MailService::class, function ($app) {
            return new MailService();
        });

        $this->app->singleton(NotiService::class, function ($app) {
            return new NotiService();
        });

        $this->app->singleton(WebService::class, function ($app) {
            return new WebService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        Blade::directive('constIn', function () {
            return "<?php echo app(Code\Services\MailService::class)->GetContsI(); ?>";
        });
        Blade::directive('constSp', function () {
            return "<?php echo app(Code\Services\MailService::class)->GetContsS(); ?>";
        });
        Blade::directive('notiMail', function () {
            return "<?php echo app(Code\Services\MailService::class)->ListNotiMessages(); ?>";
        });
        Blade::directive('notis', function () {
            return "<?php echo app(Code\Services\NotiService::class)->showNotis(); ?>";
        });
        Blade::directive('notis', function () {
            return "<?php echo app(Code\Services\WebService::class)->showCategories(); ?>";
        });
    }
}
