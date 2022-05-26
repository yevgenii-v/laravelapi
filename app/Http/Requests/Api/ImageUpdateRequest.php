<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ImageUpdateRequest extends FormRequest
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
            'name'      => ['string'],
            'path'      => ['mimes:jpg,jpeg,png'],
            'slider_id' => ['exists:sliders,id'],
            'is_active' => ['boolean'],
        ];
    }
}
