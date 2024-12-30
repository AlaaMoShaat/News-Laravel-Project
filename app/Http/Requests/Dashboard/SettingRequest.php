<?php

namespace App\Http\Requests\Dashboard;

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
            'site_name' => ['required', 'string', 'min:2', 'max:60'],
            'email' => ['required', 'email'],
            'phone' => ['string', 'required'],
            'country' => ['required', 'string', 'max:30'],
            'city' => ['required', 'string', 'max:30'],
            'street' => ['required', 'string', 'max:70'],
            'facebook' => ['required', 'string'],
            'twitter' => ['required', 'string'],
            'instagram' => ['required', 'string'],
            'youtube' => ['required', 'string'],
            'small_desc' => ['required', 'string', 'min:10'],
            'logo' => ['nullable', 'image'],
            'favicon' => ['nullable', 'image'],
        ];
    }
}
