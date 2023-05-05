<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::registerNavigationGroups([
            NavigationGroup::make()
                ->label('Documents')
                ->icon('heroicon-s-briefcase'),
            NavigationGroup::make()
                ->label('Expenses')
                ->icon('heroicon-o-currency-yen'),
            NavigationGroup::make()
                ->label('Clients'),
            NavigationGroup::make()
                ->label('Hidden'),
        ]);

        Filament::registerViteTheme('resources/css/filament.css');



        Filament::serving(function () {
            Filament::registerUserMenuItems([
                'account' => UserMenuItem::make()->url('#'),
                UserMenuItem::make()
                    ->label('Settings')
                    ->url('#')
                    ->icon('heroicon-s-cog'),
                // ...
                'logout' => UserMenuItem::make()->label('Log out'),
            ]);
        });
    }
}
