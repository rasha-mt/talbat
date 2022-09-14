<?php

namespace App\Nova\Actions;


use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\BelongsTo;
use Domain\Restaurants\Models\Category;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class AddRestaurantMeal extends Action
{
    use InteractsWithQueue, Queueable;
    public $name = 'Add Meal';

    public function handle(ActionFields $fields, Collection $models)
    {
        $model = $models->first();

        $model->categoryMeals()->create($fields->getAttributes());
    }

    public function fields(NovaRequest $request)
    {
        $options = Category::query()
            ->get()
            ->mapWithKeys(function ($category) {
                return [$category->id => $category->name];
            })
            ->toArray();

        return [
            Text::make('name')->rules('required')->sortable(),
            Textarea::make('description')->rules('required'),
            Image::make('image')->rules('required'),
            Currency::make('Price','regular_price')->rules('required'),
            Select::make(__('Category'), 'category_id')
                ->options($options)
                ->displayUsingLabels()
                ->textAlign('center')
                ->searchable()
                ->rules('required'),
        ];
    }
}
