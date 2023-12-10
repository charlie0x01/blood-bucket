<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends FormRequest
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
            'name' => ['required', 'max:100'],
            'email' => [Rule::requiredIf(function () {
                return config('boilerplate.access.user.change_email');
            }), 'max:255', 'email', Rule::unique('users')->ignore($this->user()->id)],
            'contact_no' => ['required', 'digits:11'],
            'blood_group_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'age' => ['required', 'numeric', 'digits:2'],
            'gender' => ['required'],
            'type' => ['required', 'string', 'regex:(donor|recipient)'],
            'avatar' => ['required']
        ];
    }
}
