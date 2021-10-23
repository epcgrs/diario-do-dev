import axios from 'axios';

import createAuthRefreshInterceptor from 'axios-auth-refresh';

let api = axios.create({
    baseURL: 'http://localhost/api/',
})

api.interceptors.request.use(request => {
    request.headers['Authorization'] = 'Bearer ' + localStorage.getItem('token');

    return request;
});

api.interceptors.response.use(response => {
    if (response.status === 403)
        alert('Forbidden');

    return response;
});

createAuthRefreshInterceptor(
    api,
    async (failedRequest) => {
        try {
            const response = await api.post('/auth/refresh');
            const { token } = response.data.data;
            await localStorage.setItem('token', token);
            failedRequest.config.headers['Authorization'] = 'Bearer ' + token;
            return failedRequest;
        }
        catch(e) {
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            document.location.replace(document.location.origin + '/login');
        }
    },
    {
        statusCodes: [401]
    }
);

export default api;
