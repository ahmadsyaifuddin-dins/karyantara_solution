<div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" id="form-ulasan"
    x-data="testimonialForm()">

    @include('public.partials.testimonials.partials.form.header')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 p-8 md:p-10">
        <div class="lg:col-span-7">
            @include('public.partials.testimonials.partials.form.inputs')
        </div>

        <div class="lg:col-span-5 flex flex-col pt-8 lg:pt-0 border-t lg:border-t-0 lg:border-l border-gray-100 lg:pl-8">
            @include('public.partials.testimonials.partials.form.preview')
        </div>
    </div>

    @include('public.partials.testimonials.partials.form.modal')

</div>

@include('public.partials.testimonials.partials.form.script')
