<?php

namespace App\Providers;

use App\Nova\User;
use App\Nova\Meal;
use App\Nova\Admin;
use App\Nova\Offer;
use App\Nova\Setting;
use App\Nova\Category;
use App\Nova\Tutorial;
use App\Nova\Restaurant;
use Illuminate\Http\Request;
use App\Nova\Dashboards\Main;
use Vyuldashev\NovaPermission\Role;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Blade;
use App\Nova\Dashboards\UserInsights;
use Vyuldashev\NovaPermission\Permission;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        parent::boot();

        Nova::footer(function ($request) {
            return Blade::render('
           @2022 Telescope 
        ');
        });

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Customers', [
                    MenuItem::resource(User::class),
                ])->icon('user')->collapsable(),

                MenuSection::make('Restaurants', [
                    MenuItem::resource(Restaurant::class),
                    //MenuItem::resource(Category::class),
                    //MenuItem::resource(Meal::class),
                ])->icon('newspaper')->collapsable(),

                MenuSection::make('Tutorials', [
                    MenuItem::resource(Tutorial::class),
                ])->icon('briefcase')->collapsable(),

                MenuSection::make('Offers', [
                    MenuItem::resource(Offer::class),
                ])->icon('sparkles')->collapsable(),


                MenuSection::make('Admins', [
                    MenuItem::resource(Admin::class),
                    MenuItem::resource(Role::class),
                    MenuItem::resource(Permission::class),
                ])->icon('user-group')->collapsable(),

                MenuSection::make('App settings', [
                    MenuItem::resource(Setting::class),
                ])->icon('user-group')->collapsable(),

            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user instanceof Admin;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new Main,
        ];

    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public
    function tools()
    {
        return [
            // ...
            \Vyuldashev\NovaPermission\NovaPermissionTool::make(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public
    function register()
    {
        //
    }

    protected
    function resources()
    {
        Nova::resourcesIn(app_path('Nova'));
        Nova::resources([
            User::class,
        ]);
    }
}
