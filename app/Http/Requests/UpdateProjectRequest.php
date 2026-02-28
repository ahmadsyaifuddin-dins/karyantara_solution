<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_shared' => ['required', 'boolean'],
            'client_type' => ['required', 'in:mahasiswa,umum'],
            'client_name' => ['required', 'string', 'max:255'],

            // Kolom Khusus Mahasiswa
            'npm' => ['nullable', 'string', 'max:50'],
            'class_name' => ['nullable', 'string', 'max:100'],
            'dospem_1' => ['nullable', 'string', 'max:255'],
            'dospem_2' => ['nullable', 'string', 'max:255'],
            'skripsi_title' => ['nullable', 'string', 'max:255'],

            // Detail & Keuangan
            'project_description' => ['required', 'string'],
            'status' => ['required', 'in:Pending,Progress,Revisi,Selesai'],
            'revision_notes' => ['nullable', 'string'],
            'net_income' => ['required', 'numeric', 'min:0'],
            'paid_amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,transfer'],
        ];
    }
}
