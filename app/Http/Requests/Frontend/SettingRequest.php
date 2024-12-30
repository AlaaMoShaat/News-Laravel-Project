<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:50'],
            'username' => ['required', 'string', 'min:2', 'max:50', 'unique:users,username,' . auth()->user()->id],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->user()->id],
            'phone' => ['required', 'string', 'min:10', 'max:16', 'unique:users,phone,' . auth()->user()->id],
            'country' => ['required', 'string', 'min:2', 'max:30'],
            'city' => ['required', 'string', 'min:2', 'max:30'],
            'street' => ['required', 'string', 'min:2', 'max:50'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
