<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:donor,recipient'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'age' => ['required'],
            'contact_no' => ['required', 'digits:11'],
            'gender' => ['required', 'string', 'in:male,female'],
            'blood_group_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
        ];
    }
}
