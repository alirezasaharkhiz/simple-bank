<?php

namespace App\Providers;

use App\Repositories\Account\AccountEloquentRepository;
use App\Repositories\Account\Contracts\AccountRepositoryInterface;
use App\Repositories\Card\CardEloquentRepository;
use App\Repositories\Card\Contracts\CardRepositoryInterface;
use App\Repositories\Fee\Contracts\FeeRepositoryInterface;
use App\Repositories\Fee\FeeEloquentRepository;
use App\Repositories\Transaction\Contracts\TransactionRepositoryInterface;
use App\Repositories\Transaction\TransactionEloquentRepository;
use App\Services\Account\AccountService;
use App\Services\Account\AccountServiceInterface;
use App\Services\Card\CardService;
use App\Services\Card\CardServiceInterface;
use App\Services\Transaction\TransactionService;
use App\Services\Transaction\TransactionServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /** repositories */
        $this->app->bind(CardRepositoryInterface::class, CardEloquentRepository::class);
        $this->app->bind(AccountRepositoryInterface::class, AccountEloquentRepository::class);
        $this->app->bind(FeeRepositoryInterface::class, FeeEloquentRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionEloquentRepository::class);
        /** services */
        $this->app->bind(CardServiceInterface::class, CardService::class);
        $this->app->bind(AccountServiceInterface::class, AccountService::class);
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
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
