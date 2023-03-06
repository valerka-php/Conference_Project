<?php

namespace Valerjan\AvailableTime;
;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class AvailableTime extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'available-time';

    public function start($start)
    {
        return $this->withMeta(['start_time' => $start]);
    }

    public function end($end)
    {
        return $this->withMeta(['end_time' => $end]);
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
        if ($resource->getAttribute('start_time')) {
            $this->start($resource->getAttribute('start_time'));
        }
        if ($resource->getAttribute('end_time')) {
            $this->end($resource->getAttribute('end_time'));
        }
    }
}
