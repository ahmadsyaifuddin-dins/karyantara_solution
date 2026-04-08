// resources/js/modules/tom-select.js
import TomSelect from 'tom-select';

document.addEventListener('alpine:init', () => {
    Alpine.data('searchableDropdown', () => ({
        init() {
            // Inisialisasi Tom Select pada elemen select yang di-referensikan (x-ref="selectNode")
            new TomSelect(this.$refs.selectNode, {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Ketik untuk mencari...",
                controlInput: '<input class="border-none shadow-none focus:ring-0 outline-none w-full bg-transparent">',
            });
        }
    }));
});