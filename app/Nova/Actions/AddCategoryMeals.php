<?php

namespace App\Nova\Actions;

use App\Nova\Category;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class AddCategoryMeals extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Add Meal';

    public function handle(ActionFields $fields, Collection $models)
    {
        $model = $models->first();
        $model->meals()->create($fields->getAttributes());
    }

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('name')->rules('required')->sortable(),
            Textarea::make('description')->rules('required'),
            Image::make('image')->rules('required'),
            Currency::make('Price','regular_price')->rules('required'),
            HasMany::make('extras')
        ];
    }
}
