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
            'fio' => 'required|max:255|string',
            'phone_number' => 'required|max:255',
            'location' => 'required|max:255|string',
            'mail' => 'required|max:255|string',
            'title_id' => 'exists:titles,id',
            'title' => 'required_without:title_id|max:255|string'
        ];
    }
}
