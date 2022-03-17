<?php

namespace App\Http\Requests\Client;

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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fio' => 'filled|max:255|string',
            'phone_number' => 'filled|max:255',
            'location' => 'filled|max:255|string',
            'mail' => 'filled|max:255|string',
            'title' => 'filled|nullable|max:255|string',
            'title_id' => 'filled|nullable|exists:titles,id',
            'date_time' => 'filled|date',
            'status_id' => 'filled|exists:statuses,id',
        ];
    }
}
