<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BloodRR extends FormRequest
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
            'recipient_name' => 'required|string|min:3',
            'gender' => 'required|string|in:male,female',
            'contact_no' => 'required|numeric|digits:11',
            'age' => 'required|numeric',
            'blood_group_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address' => 'required|string|max:150]'
        ];
    }

    public function messages()
    {
        return [
            'gender.required' => "You must select the Gender.",
            'blood_group_id.required' => "You must select the Blood Group.",
            'city_id.required' => "You must select the City.",
            'contact_no.required' => "You must provide your contact no.",
            'address.required' => "You must provide your address.",
        ];
    }
}
