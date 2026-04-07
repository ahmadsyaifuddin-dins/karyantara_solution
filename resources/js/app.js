import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Modul Kustom
import './modules/sweetalert';
import './modules/alpine-components';
import './modules/ai-textarea';
import './modules/org-chart';
import './modules/role-sync';

Alpine.start();