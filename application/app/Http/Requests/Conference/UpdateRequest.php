<?php

namespace App\Http\Requests\Conference;

use App\Models\Conference;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->conference);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => ['required', 'numeric'],
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'date' => ['required', 'date'],
            'latitude' => ['numeric'],
            'longitude' => ['numeric'],
            'country' => ['required', 'string', 'max:255'],
            'category_id' => ['numeric'],
        ];
    }
}
