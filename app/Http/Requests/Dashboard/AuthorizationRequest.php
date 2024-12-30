<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationRequest extends FormRequest
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
            'role' => ['required', 'min:2', 'max:60'],
            'permessions' => ['required', 'array', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'permessions.required' => 'You must select at least one permission.',
            'permessions.array' => 'Invalid permissions format.',
            'permessions.min' => 'You must select at least one permission.',
            'role.required' => 'Role is required.',
            'role.min' => 'Role must be at least 2 characters.',
            'role.max' => 'Role must not exceed 60 characters.',
        ];
    }
}
