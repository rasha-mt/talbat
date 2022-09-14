<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Acme\Analytics\Analytics;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\UsersPerDay;
use App\Nova\Metrics\NewReleases;
use App\Nova\Metrics\UsersPerPlan;
use App\Nova\Metrics\UsersProgress;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            (new NewUsers)->dynamicHeight(),
            (new UsersPerDay)->width('2/3')->dynamicHeight(),
           // new UsersPerPlan,
            new UsersProgress,
            new NewReleases
        ];
    }
}
