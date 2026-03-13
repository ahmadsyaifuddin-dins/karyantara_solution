<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('testimonialForm', () => ({
            name: '{{ old('client_name') }}',
            title: '{{ old('client_title') }}',
            review: `{{ old('testimonial') }}`,
            rating: {{ old('rating', 5) }},
            hoverRating: 0,
            imagePreview: null,
            showReferenceModal: false,

            get displayName() {
                return this.name || 'Freya Jayawardana';
            },
            get displayTitle() {
                return this.title || 'Member JKT48';
            },
            get displayReview() {
                return this.review ||
                    'Kerja sama dengan Karyantara Solution benar-benar memuaskan! Timnya sangat profesional, responsif, dan memberikan hasil web yang elegan serta melebihi ekspektasi aku.';
            },
            get displayImage() {
                if (this.imagePreview) return this.imagePreview;
                if (this.name)
                    return `https://ui-avatars.com/api/?name=${encodeURIComponent(this.name)}&background=1E293B&color=fff`;
                return '{{ asset('dummy/testimoni/freya.jpg') }}';
            },

            handleImageSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    this.imagePreview = URL.createObjectURL(file);
                } else {
                    this.imagePreview = null;
                }
            }
        }))
    })
</script>
