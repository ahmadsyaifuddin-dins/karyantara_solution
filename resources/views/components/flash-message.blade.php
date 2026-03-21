@if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {

            @if (session()->has('success'))
                window.Toast.fire({
                    iconHtml: '<i class="fa-solid fa-circle-check text-amber-500 text-xl"></i>',
                    title: '{{ session('success') }}',
                    customClass: {
                        icon: 'border-0 m-0'
                    }
                });
            @endif

            @if (session()->has('error'))
                window.Toast.fire({
                    iconHtml: '<i class="fa-solid fa-circle-exclamation text-red-400 text-xl"></i>',
                    title: '{{ session('error') }}',
                    customClass: {
                        icon: 'border-0 m-0'
                    }
                });
            @endif

        });
    </script>
@endif
