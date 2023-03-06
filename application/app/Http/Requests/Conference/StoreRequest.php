<?php

namespace App\Http\Requests\Conference;

use App\Models\Conference;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Conference::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:2', 'max:255', 'string'],
            'date' => ['required', 'min:2', 'max:255', 'string'],
            'latitude' => ['numeric'],
            'longitude' => ['numeric'],
            'country' => ['required', 'string'],
            'category_id' => ['required','numeric']
        ];
    }
}
