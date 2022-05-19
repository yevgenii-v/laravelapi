<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'              => ['string'],
            'email'             => ['string', 'unique:users,email'],
            'new_password'      => ['string', 'confirmed', 'min:6'],
            'current_password'  => ['required'],
        ];
    }

    /**
     * @param $validator
     * @return bool
     */
    public function withValidator($validator): bool
    {
        $validator->after(function ($validator) {
            if ( !Hash::check($this->current_password, $this->user()->password) ) {
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
            }
        });

        return true;
    }
}
