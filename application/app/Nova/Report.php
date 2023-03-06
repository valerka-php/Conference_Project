<?php

namespace App\Nova;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\File;
use Valerjan\AvailableTime\AvailableTime;
use Tsungsoft\ErrorMessage\ErrorMessage;

class Report extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Report>
     */
    public static $model = \App\Models\Report::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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

            Select::make('Conference', 'conference_id')
                ->options(function () {
                    $conferences = \App\Models\Conference::all();
                    $result = [];

                    foreach ($conferences as $conference) {
                        $result[$conference->id] = $conference->title;
                    }

                    return $result;
                })
                ->onlyOnForms()
                ->rules('required'),

            Select::make('Announcers', 'creator_id')
                ->options(function () {
                    return \App\Models\User::getAnnouncers();
                })->onlyOnForms()
                ->rules('required'),

            Text::make('Title', 'title')
                ->sortable()
                ->rules('required', 'max:255', 'min:2'),

            Textarea::make('Description', 'description'),

            File::make('Presentation')
                ->disk('public')
                ->rules(['mimes:ppt,pptx,odp', 'max:10000']),

            Text::make('start_url')
                ->displayUsing(function ($value) {
                    return Str::limit($value, 30);
                })->copyable(),

            Text::make('join_url')
                ->displayUsing(function ($value) {
                    return Str::limit($value, 30);
                })->copyable(),

            AvailableTime::make('Time')
                ->start('start_time')
                ->end('end_time'),

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
        return [];
    }
}
