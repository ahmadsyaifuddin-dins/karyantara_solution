<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil ID user yang sedang diedit dari route
        $adminId = $this->route('admin')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($adminId)],
            'password' => ['nullable', 'confirmed', Password::defaults()], // Nullable agar password tidak wajib diisi saat edit
        ];
    }
}
