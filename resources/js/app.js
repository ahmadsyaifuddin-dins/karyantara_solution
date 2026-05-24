import './bootstrap';
import Alpine from 'alpinejs';

// 1. Daftarkan Alpine ke window (global)
window.Alpine = Alpine;

// 2. Import modul-modul kustom
import './modules/sweetalert';
import './modules/alpine-components';
import './modules/ai-textarea';
import './modules/org-chart';
import './modules/tom-select';
import './modules/role-sync';

// IMPORT MODUL AURORA DENGAN NAMA VARIABEL
import auroraBackground from './modules/aurora-bg';

// 3. Daftarkan fungsi aurora ke Alpine
window.Alpine.data('auroraBackground', auroraBackground);

// 4. Jalankan Alpine
Alpine.start();