<?php

namespace App\Nova;

use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Dniccum\PhoneNumber\PhoneNumber;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\BelongsTo;

class Listener extends Resource
{
    const ROLE_LISTENER = 1;
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

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

            Hidden::make('User', 'role_id')->default(function ($request) {
                return $request->user()->role_id;
            })->default(self::ROLE_LISTENER),

            Text::make('First Name', 'firstname')
                ->sortable()
                ->rules('required', 'max:255', 'min:2'),

            Text::make('Last Name', 'lastname')
                ->sortable()
                ->rules('required', 'max:255', 'min:2'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Date::make('Birthday', 'birthdate')
                ->sortable()
                ->rules('required'),

            BelongsTo::make('Country')->viewable(false),

            PhoneNumber::make('Phone Number', 'phone')
                ->format('+## (###) ## ## ##')
                ->disableValidation()
                ->rules('required')
                ->onlyOnForms(),

            Text::make('Email')
                ->sortable()
                ->rules('email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),
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

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('role_id', self::ROLE_LISTENER);
    }
}
