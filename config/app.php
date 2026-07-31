<?php 

use App\Providers\AppServiceProvider;
use App\Providers\DatabaseServiceProvider;
use App\Providers\RouteServiceProvider;


return [
    'providers' => [

        AppServiceProvider::class,
        DatabaseServiceProvider::class,
        RouteServiceProvider::class,
    ],
]; 