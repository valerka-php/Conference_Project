<?php

namespace App\Http\Requests\Report;

use App\Models\Report;
use App\Models\User;
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
        return $this->user()->can('create', Report::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'conference_id' => ['required'],
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'category_id' => ['required', 'numeric']
        ];
    }
}
