let baseUrl = null;
let csrfToken = null;
let baseUrlElement = document.head.querySelector('meta[name="base-url"]');
let csrfTokenElement = document.head.querySelector('meta[name="csrf-token"]');

if (baseUrlElement) {
    baseUrl = baseUrlElement.content || null;
}
if (csrfTokenElement) {
    csrfToken = csrfTokenElement.content || null;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Configure Axios for HTTP Requests
const axios = require('axios');
const httpClient = axios.create({
    baseURL: baseUrl, // Register the Application base URL
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, // Register the CSRF Token
    },
    // timeout: 10000,
});

export default httpClient;
