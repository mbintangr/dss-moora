<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlternativeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'c1' => ['required', 'integer'],
            'c2' => ['required', 'integer'],
            'c3' => ['required', 'integer'],
            'c4' => ['required', 'integer'],
            'c5' => ['required', 'integer'],
            'c6' => ['required', 'integer'],
            'c7' => ['required', 'integer'],
            'c8' => ['required', 'integer'],
            'c9' => ['required', 'integer'],
            'c10' => ['required', 'integer'],
        ];
    }
}
