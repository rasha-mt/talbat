<?php

namespace App\Nova\Actions;

use Laravel\Nova\Fields\ID;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Domain\Restaurants\Models\MealExtra;
use Domain\Restaurants\Casts\ExtraCaster;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class AddMealExtra extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Add Meal Extra';
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $fields = $fields->getAttributes();

            MealExtra::query()->create([
                'meal_id' => $model->id,
                'title'   => $fields['title'],
                'options' => $fields['options']
            ]);
        }
    }

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('title')->rules('required'),
            Flexible::make('options')
                ->addLayout('Meal Extra', 'options_list', [
                    Text::make('name')->rules('required'),
                    Currency::make('price')->currency('EUR')->rules('required'),
                    Currency::make('extra_price_over_main')->currency('EUR')->rules('required'),
                ])
                ->button('Add Another Meal Extra')
                ->fullWidth(),
        ];
    }
}
