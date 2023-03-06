<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'checkbox' => ['required'],
            'title' => ['string', 'max:25', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'checkbox.required' => 'Please select one of the checkboxes',
        ];
    }
}
