<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Pastikan hanya user yang login yang bisa melakukan request ini
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'type' => 'required|in:Internal Board,Client Meeting,Project Sync,Evaluation',
            'agenda_summary' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'maps_link' => 'nullable|url|max:255',
            'status' => 'required|in:Scheduled,Ongoing,Completed,Canceled',
            'minutes_of_meeting' => 'nullable|string',
            // action_items kita set nullable, nanti diatur via UI apakah dikirim sebagai array
            'action_items' => 'nullable|array', 
        ];
    }

    /**
     * Custom pesan error (Opsional, agar lebih user-friendly)
     */
    public function messages(): array
    {
        return [
            'end_time.after' => 'Waktu selesai rapat harus setelah waktu mulai.',
            'maps_link.url' => 'Link Google Maps harus berupa URL yang valid.',
        ];
    }
}