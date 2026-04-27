// resources/js/modules/tom-select.js
import TomSelect from 'tom-select';

document.addEventListener('alpine:init', () => {
    Alpine.data('searchableDropdown', () => ({
        selectInstance: null,

        init() {
            // Inisialisasi dan simpan instancenya ke dalam variabel
            this.selectInstance = new TomSelect(this.$refs.selectNode, {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Ketik untuk mencari...",
                controlInput: '<input class="border-none shadow-none focus:ring-0 outline-none w-full bg-transparent">',
            });

            // Pasang pendengar (listener) untuk event dari AI
            window.addEventListener('ai-tags-suggested', (e) => {
                // Pastikan yang diupdate HANYA input yang memiliki ID 'tags'
                if (this.$refs.selectNode.id === 'tags') {
                    const tagIds = e.detail.tags;
                    
                    // Lakukan loop dan paksa ID menjadi String!
                    tagIds.forEach(id => {
                        this.selectInstance.addItem(String(id));
                    });
                }
            });
        }
    }));
});