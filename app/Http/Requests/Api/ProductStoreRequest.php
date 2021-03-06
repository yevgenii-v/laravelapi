<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name'          => ['required', 'string'],
            'description'   => ['required', 'string'],
            'category_id'   => ['exists:categories,id'],
            'related_id'    => ['array', 'exists:products,id'],
        ];
    }
}
