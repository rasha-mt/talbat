<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboard;
use Acme\Analytics\Analytics;

class UserInsights extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new Analytics
        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'user-insights';
    }
}
