<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $phone_number = null;

    protected function prepareForValidation()
    {
        $input = $this->all();

        if (isset($input['phone_number'])) {
            $phone_number = intval($input['phone_number']);
            if ($phone_number > 0) {
                $this->phone_number = $phone_number;
            }
        }
        $this->replace($input);
    }

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
        $fio_phone_number_uniq = Rule::unique('clients')
            ->where(function ($query) {
                if ($this->phone_number !== null) {
                    $query->where([
                        ['phone_number', $this->phone_number],
                    ]);
                } else {
                    $query->whereNull('phone_number');
                }
            });

        return [
            'fio' => [
                'required',
                'max:255',
                'string',
                $fio_phone_number_uniq
            ],
            'phone_number' => 'required|max:255',
            'location' => 'required|max:255|string',
            'mail' => 'required|max:255|string',
            'title_id' => 'filled|nullable|exists:titles,id',
            'title' => 'filled|max:255|string',
            'date_time' => 'required|date'
        ];
    }
}
