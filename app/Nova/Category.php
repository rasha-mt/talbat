<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use App\Nova\Actions\AddCategoryMeals;
use Laravel\Nova\Http\Requests\NovaRequest;
use Domain\Restaurants\Models\Restaurant;

class Category extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Domain\Restaurants\Models\Category::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $options = Restaurant::query()
            ->get()
            ->mapWithKeys(function ($restaurant) {
                return [$restaurant->id => $restaurant->name];
            })
            ->toArray();

        return [
            ID::make()->sortable(),
            Text::make('name')->required()->sortable(),

            BelongsTo::make('restaurant')->searchable()->sortable()
                ->displayUsing(function ($restaurant) {
                    return $restaurant->name;
                })
                ->exceptOnForms(),

            Select::make(__('Restaurant'), 'restaurant_id')
                ->options($options)
                ->displayUsingLabels()
                ->textAlign('center')
                ->searchable()
                ->rules('required'),

            Number::make(__('order'), 'order')
                ->creationRules('required', 'unique:tutorials,order')
                ->updateRules('required', 'unique:tutorials,order,{{resourceId}}'),

            Boolean::make('is_active')->sortable(),
            HasMany::make('meals')->hideFromIndex(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new AddCategoryMeals($this->resource))->showInline(),
        ];
    }
}
