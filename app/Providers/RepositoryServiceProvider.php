<?php 

namespace App\Providers;

use App\Repository\StudentRepository;
use App\Repository\StudentRepositoryInterface;


class RepositoryServiceProvider extends ServiceProvider
{
    public function register():void 
    {
        // Register application services here
        
        $this->container->bind(
            StudentRepositoryInterface::class, //  abstract
            StudentRepository::class // concrete
        );

    }

    public function boot():void
    {
        // Bootstrapping application services here
    }
}