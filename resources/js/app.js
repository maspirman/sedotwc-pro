import './bootstrap';

import Alpine from 'alpinejs';

// Import Summernote CSS
import 'summernote/dist/summernote-lite.min.css';

// Import Summernote JS and make it globally available
import summernote from 'summernote/dist/summernote-lite.min.js';
window.Summernote = summernote;

window.Alpine = Alpine;

Alpine.start();
