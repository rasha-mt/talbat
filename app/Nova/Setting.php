<?php

namespace App\Nova;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use App\Models\Setting as SettingModel;
use Laravel\Nova\Http\Requests\NovaRequest;

class Setting extends Resource
{
    public static $model = SettingModel::class;

    public static $title = 'key';

    public static $search = [
        'key', 'description',
    ];

    public static function label()
    {
        return __('Settings');
    }

    public function fields(Request $request)
    {
        /** @var SettingModel $setting */
        $setting = $this->resource;

        $value_field = match ($setting?->type) {
            SettingModel::BOOLEAN_TYPE => $this->makeBooleanField(),
            SettingModel::NUMBER_TYPE => $this->makeNumberField(),
            SettingModel::TEXT_TYPE, null => $this->makeTextField(),
            SettingModel::URL_TYPE => $this->makeURLField(),
        };

        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Name'), 'key')
                ->displayUsing(function () {
                    return Str::headline($this->key);
                })
                ->readonly()
                ->sortable(),
            Text::make(__('Description'), 'description')
                ->textAlign('right')
                ->required(),
            Text::make(__('Category'), 'category')
                ->hideFromIndex()
                ->readonly()
                ->sortable(),

            $value_field,

        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return
            [

            ];
    }

    public function authorizedToDelete(Request $request)
    {
        return true;
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }

    private function makeBooleanField(): Field
    {
        return Boolean::make(__('Value'), 'value')
            ->textAlign('right');
    }

    private function makeNumberField(): Field
    {
        return Number::make(__('Value'), 'value')
            ->textAlign('right')
            ->rules('required', 'numeric', 'gte:0');
    }

    private function makeTextField(): Field
    {
        return Text::make(__('Value'), 'value')
            ->textAlign('right')
            ->rules('required');
    }

    private function makeURLField(): Field
    {
        return Text::make(__('Value'), 'value')
            ->textAlign('right')
            ->rules('required', 'url');
    }

}
