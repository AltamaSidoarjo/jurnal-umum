<?php

namespace Altamasoft\JurnalUmum;

use Illuminate\Support\ServiceProvider;

class JurnalUmumServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Daftarkan binding, config, dsb
    }

    public function boot()
    {
        // Load route, migration, dsb
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
