import axios from 'axios';

let csrfReady = false;

async function ensureCsrfCookie() {
    if (csrfReady) return;
    await axios.get('/sanctum/csrf-cookie');
    csrfReady = true;
}

async function request(method, url, data = undefined, config = {}) {
    await ensureCsrfCookie();
    const apiUrl = url.startsWith('/api/') ? url : `/api${url.startsWith('/') ? url : `/${url}`}`;
    return axios({
        method,
        url: apiUrl,
        data,
        ...config,
    });
}

window.api = {
    request,
    get: (url, config) => request('get', url, undefined, config),
    post: (url, data, config) => request('post', url, data, config),
    put: (url, data, config) => request('put', url, data, config),
    patch: (url, data, config) => request('patch', url, data, config),
    delete: (url, config) => request('delete', url, undefined, config),
};

