@php
    $reminders = [
        'Bug terbesar manusia adalah merasa dirinya tidak punya bug (kesalahan).',
        'Kode yang kamu tulis hari ini akan di-maintenance oleh orang lain besok. Tulislah dengan rapi dan empati.',
        'Rezeki sudah diatur, tapi kualitas kode dan layanan ke klien adalah tanggung jawab kita.',
        'Istirahatlah ketika lelah, bukan berhenti. Server saja butuh di-restart, apalagi fisik manusianya.',
    ];
@endphp

<div
    class="bg-amber-50 rounded-xl p-6 md:p-8 border border-amber-200 flex flex-col md:flex-row items-start md:items-center gap-6 mt-2">
    <div class="w-full md:w-1/3">
        <div class="flex items-center gap-3 mb-2">
            <i class="fa-solid fa-lightbulb text-amber-500 text-2xl"></i>
            <h2 class="text-xl font-bold text-[#1E293B]">Pengingat Harian</h2>
        </div>
        <p class="text-gray-600 text-sm">Prinsip kerja tim Karyantara Solution dalam menjaga kualitas dan mental.</p>
    </div>

    <div class="w-full md:w-2/3">
        <div class="bg-white/60 rounded-lg p-5">
            <ul class="space-y-3">
                @foreach ($reminders as $reminder)
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-amber-500 mt-1"></i>
                        <span class="text-[#1E293B] text-sm md:text-base font-medium">{{ $reminder }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
