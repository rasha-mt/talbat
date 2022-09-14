<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class AddRestaurantCategory extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Add Category';

    public function handle(ActionFields $fields, Collection $models)
    {
        $model = $models->first();
        $model->categories()->create($fields->getAttributes());
    }

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('name')->required()->sortable(),

            Number::make(__('order'), 'order')
                ->creationRules('required', 'unique:tutorials,order')
                ->updateRules('required', 'unique:tutorials,order,{{resourceId}}'),

            Boolean::make('is_active')->sortable(),
        ];
    }
}
