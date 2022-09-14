<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use App\Nova\Actions\AddRestaurantMeal;
use Laravel\Nova\Fields\HasManyThrough;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Actions\AddRestaurantCategory;
use Trinityrank\GoogleMapWithAutocomplete\TRMap;

class Restaurant extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Domain\Restaurants\Models\Restaurant::class;
    public static $showColumnBorders = true;

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
        'id', 'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            TextArea::make('description')->sortable()
                ->rules('required', 'max:500'),

            Image::make('logo')->rules('required'),

            Image::make('image')->rules('required'),

            TRMap::make('Map')
                ->hideLatitude()
                ->hideLongitude()
                ->hideFromIndex(),

            Text::make('address')->hideFromIndex(),
            Number::make('Shipping Duration', 'shipping_duration'),
            Number::make('order'),
            HasMany::make('Categories')->hideFromIndex(),
            HasManyThrough::make('Meals', 'categoryMeals', Meal::class),

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
            (new AddRestaurantCategory($this->resource))->showInline(),
            (new AddRestaurantMeal($this->resource))->showInline(),

        ];
    }
}
