import api from './Api'
/**
 * AuthService
 *
 * @module AuthService
 *
 */
class AuthService {

    login(user) {
        return api
            .post('users/login', {
                email: user.email,
                password: user.password
            })
            .then(response => {

                if (response.data.user && response.data.user.token) {
                    localStorage.setItem('user', JSON.stringify( response.data.user  ));
                    localStorage.setItem('token', response.data.user.token);
                }

                return response.data;
            });
    }

    register(user) {
        return api
            .post('users/register', {
                name: user.name,
                email: user.email,
                password: user.password
            })
            .then(response => {

                if (response.data.user.token) {
                    localStorage.setItem('user', JSON.stringify( response.data.user  ));
                    localStorage.setItem('token', response.data.user.token);
                }

                return response.data.user;
            });
    }

    logout() {
        return api.post('users/logout')
            .then(response => {
                localStorage.removeItem('user');
                localStorage.removeItem('token');
                return response.data;
            })
            .catch(error => {
                return error;
            });
    }

}

export default new AuthService();
