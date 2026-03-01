<?php

namespace App\Http\Requests;

use App\Models\Testimonial;
use Illuminate\Foundation\Http\FormRequest;

class StoreGuestTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Guest boleh akses
    }

    protected function prepareForValidation()
    {
        if ($this->has('phone_number')) {
            // Bersihkan semua karakter selain angka (misal user input pakai spasi atau strip)
            $phone = preg_replace('/[^0-9]/', '', $this->phone_number);

            // Konversi awalan 0 menjadi 62
            if (str_starts_with($phone, '0')) {
                $phone = '62'.substr($phone, 1);
            }

            // Timpa data request dengan yang sudah diformat
            $this->merge([
                'phone_number' => $phone,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'min:12', 'max:15', 'unique:testimonials,phone_number', 'regex:/^[0-9]+$/'],
            'client_title' => ['nullable', 'string', 'max:255'],
            'testimonial' => ['required', 'string', 'min:10'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            // LAYER 2: HONEYPOT
            'company_website' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_name.required' => 'Nama lengkap wajib diisi.',
            'client_name.max' => 'Nama lengkap maksimal 255 karakter.',

            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email yang dimasukkan tidak valid.',
            'email.max' => 'Alamat email terlalu panjang.',

            'testimonial.required' => 'Ulasan Anda wajib diisi.',
            'testimonial.min' => 'Ulasan terlalu pendek, minimal harus :min karakter.', // :min otomatis jadi 10

            'rating.required' => 'Mohon berikan rating bintang Anda.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',

            'phone_number.unique' => 'Nomor WhatsApp ini sudah pernah memberikan ulasan. Terima kasih!',
            'phone_number.min' => 'Nomor WhatsApp minimal 12 digit.',
            'phone_number.max' => 'Nomor WhatsApp maksimal 15 digit.',
            'phone_number.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',

            'profile_image.image' => 'File foto profil harus berupa gambar.',
            'profile_image.mimes' => 'Format foto profil harus jpeg, png, jpg, atau webp.',
            'profile_image.max' => 'Ukuran foto profil tidak boleh lebih dari 2MB.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Evaluasi Honeypot
            if (! empty($this->company_website)) {
                $validator->errors()->add('company_website', 'Sistem mendeteksi aktivitas mencurigakan (Spam).');
            }

            // LAYER 3: Validasi 1 Email Per Minggu
            $lastTestimonial = Testimonial::where('email', $this->email)
                ->where('created_at', '>=', now()->subDays(7))
                ->first();

            if ($lastTestimonial) {
                $validator->errors()->add('email', 'Terima kasih! Anda sudah mengirim ulasan dalam minggu ini. Silakan coba lagi nanti.');
            }
        });
    }
}
