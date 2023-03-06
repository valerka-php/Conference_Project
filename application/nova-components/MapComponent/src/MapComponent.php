<?php

namespace Valerjan\MapComponent;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class MapComponent extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'map-component';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));

        parent::__construct($name, $this->attribute);

        $this->mapId(config('app.google_map_id'));
        $this->apiKey(config('app.google_key'));
    }

    public function mapId($apiKey)
    {
        return $this->withMeta(['map_id' => $apiKey]);
    }
    public function apiKey($apiKey)
    {
        return $this->withMeta(['api_key' => $apiKey]);
    }

    public function latitude($latitude)
    {
        return $this->withMeta(['latitude' => $latitude]);
    }

    public function longitude($longitude)
    {
        return $this->withMeta(['longitude' => $longitude]);
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        foreach ($request->input($attribute) as $attr => $data) {
            if ($data != 'null') {
                $model->setAttribute($attr, $data);
            }
        }
    }

    public function resolve($resource, $attribute = null)
    {
        if ($resource->getAttribute('latitude')) {
            $this->latitude(floatval($resource->getAttribute('latitude')));
        }
        if ($resource->getAttribute('longitude')) {
            $this->longitude(floatval($resource->getAttribute('longitude')));
        }
    }
}
