<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('phone_number')) {
            $phone = preg_replace('/[^0-9]/', '', $this->phone_number);
            if (str_starts_with($phone, '0')) {
                $phone = '62'.substr($phone, 1);
            }
            $this->merge(['phone_number' => $phone]);
        }
    }

    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'client_title' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],

            // VALIDASI UNIQUE BIASA
            'phone_number' => [
                'required',
                'string',
                'min:12',
                'max:15',
                'regex:/^[0-9]+$/',
                'unique:testimonials,phone_number',
            ],

            'testimonial' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
