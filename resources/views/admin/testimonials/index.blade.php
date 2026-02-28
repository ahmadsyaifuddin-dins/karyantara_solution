<x-app-layout>
    <x-slot name="header">
        @include('admin.testimonials.partials.index.header')
    </x-slot>

    <div class="py-12" x-data="bulkManager('{{ route('admin.testimonials.bulk-action') }}', '{{ route('admin.testimonials.action-all') }}')">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @include('admin.testimonials.partials.index.alert')

            <x-admin.search-filter action="{{ route('admin.testimonials.index') }}"
                searchPlaceholder="Cari nama klien, email, atau isi ulasan..." :options="['published' => 'Dipublikasi', 'pending' => 'Pending']" />

            @include('admin.testimonials.partials.index.bulk-actions')

            @include('admin.testimonials.partials.index.table')

        </div>
    </div>
</x-app-layout>
