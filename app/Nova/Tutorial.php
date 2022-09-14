<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Tutorial extends Resource
{
    public static $model = \App\Models\Tutorial::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static function label()
    {
        return __('Tutorial');
    }

    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Title'), 'title')
                ->required()
                ->sortable(),
            Text::make(__('text'), 'text')
                ->required()
                ->sortable(),

            Image::make(__('Image'), 'image')
                ->disk('s3')
                ->thumbnail(function () {
                    return $this->image;
                })
                ->preview(function () {
                    return $this->image;
                })
                ->rules('required'),

            Boolean::make(__('enabled'), 'enabled')->sortable(),
            Number::make(__('order'), 'order')
                ->creationRules('required', 'unique:tutorials,order')
                ->updateRules('required', 'unique:tutorials,order,{{resourceId}}')
                ->sortable(),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [

        ];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
