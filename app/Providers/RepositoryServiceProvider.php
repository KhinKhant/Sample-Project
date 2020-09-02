<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\Interfaces\EmployeeDepartmentPositionRepositoryInterface;
use App\Repositories\EmployeeDepartmentPositionRepository;

use App\Repositories\Interfaces\PositionRepositoryInterfaces;
use App\Repositories\PositionRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);//To bind EmployeeRepository with EmployeeRepositoryInterface
        $this->app->bind(EmployeeDepartmentPositionRepositoryInterface::class, EmployeeDepartmentPositionRepository::class);
        $this->app->bind(PositionRepositoryInterfaces::class, PositionRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
