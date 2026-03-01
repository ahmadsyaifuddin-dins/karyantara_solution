<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortfolioRequest extends FormRequest
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

            // Opsional saat edit (karena mungkin cuman mau ganti judul aja)
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            // Menangani penghapusan gambar lama & set thumbnail baru (Nanti di-handle Alpine.js)
            'deleted_images' => ['nullable', 'array'],
            'deleted_images.*' => ['integer'],
            'existing_thumbnail_id' => ['nullable', 'integer'],
            'thumbnail_index' => ['nullable', 'integer'],
        ];
    }
}
