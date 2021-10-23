import AuthService from '../../services/modules/Auth'

const user = JSON.parse(localStorage.getItem('user'))

const initialState = user
    ? { status: {loggedIn: true}, user, message: '' }
    : { status: {loggedIn: false}, user: null, message: '' }

export default {
    namespaced: true,
    state: initialState,
    actions: {
        login({commit}, user) {
            return AuthService.login(user).then(
                user => {

                    if(user.status) {
                        if(!user.status && user.message.length && user.message.length > 0) {
                            return commit('loginMessage', user.message);
                        }
                        commit('loginSuccess', user.user)
                    }

                    return Promise.resolve(user)
                },
                error => {
                    commit('loginFailure')
                    return Promise.reject(error)
                }
            )
        },
        register({commit}, user) {
            return AuthService.register(user).then(
                user => {
                    if(user.status) {
                        if(!user.status && user.message.length && user.message.length > 0) {
                            return commit('loginMessage', user.message);
                        }
                    }

                    commit('loginSuccess', user)
                    return Promise.resolve(user)
                },
                error => {
                    commit('loginFailure')
                    return Promise.reject(error)
                }
            )
        },
        logout({commit}) {
            return AuthService.logout().then(
                success => {
                    commit('logoutActions')
                    return Promise.resolve(success)
                },
                error => {
                    return Promise.reject(error)
                }
            );
        },
    },
    getters: {
        userLoggedIn: (state) => {
            return state.status.loggedIn
        },
        userData: (state) => {
            return state.user
        },
    },
    mutations: {
        loginSuccess(state, user) {
            state.status.loggedIn = true;
            state.user = user;
        },
        loginFailure(state) {
            state.status.loggedIn = false;
            state.user = null;
        },
        logoutMutation(state) {
            state.status.loggedIn = false;
            state.user = null;
        },
        loginMessage(state, message) {
            state.message = message;
        },
        logoutActions(state) {
            state.status.loggedIn = false;
            state.status.user = null;
            state.status.message = '';
        }
    }

}
