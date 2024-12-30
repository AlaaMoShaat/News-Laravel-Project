<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $rules = [
            'title' => ['required', 'string', 'min:3', 'max:50'],
            'desc' => ['required', 'string', 'min:100'],
            'category_id' => ['exists:categories,id'],
            'comment_able' => ['in:on,off,0,1'],
            'small_desc' => ['required', 'string', 'min:70', 'max:200'],
            'images' => ['required'], // Base rule for images
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Validation for each image
            'status' => ['nullable', 'in:0,1']
        ];

        if ($this->input('skip_images_validation')) {
            unset($rules['images']);
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'A Title is required',
            // 'images.required' => 'A images is required',
        ];
    }
}