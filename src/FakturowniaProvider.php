<?php

namespace MattM\FFL;

use Illuminate\Support\ServiceProvider;

class FakturowniaProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/fakturownia.php', 'fakturownia'
        );

        $this->app->singleton(Fakturownia::class, function() {
            return new Fakturownia();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/fakturownia.php' => config_path('fakturownia.php'),
        ]);
    }
}
