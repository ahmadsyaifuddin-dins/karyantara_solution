<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'admin_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'project_url' => ['nullable', 'url', 'max:255'],

            // Validasi Multiple File
            'images' => ['required', 'array', 'min:1'], // Harus minimal 1 gambar
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'thumbnail_index' => ['required', 'integer'], // Index gambar mana yang dicentang sbg thumbnail
        ];
    }
}
