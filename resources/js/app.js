import './bootstrap';
import Alpine from 'alpinejs';

// 1. Daftarkan Alpine ke window (global)
window.Alpine = Alpine;

// 2. Import modul-modul kustom kita
import './modules/sweetalert';
import './modules/alpine-components';
import './modules/ai-textarea';
import './modules/org-chart';
import './modules/tom-select';

// 3. Jalankan Alpine
Alpine.start();