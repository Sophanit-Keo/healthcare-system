import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// Needed for Sanctum SPA auth when calling `/api/*` from Blade pages.
window.axios.defaults.withCredentials = true;
