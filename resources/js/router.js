import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home.vue';
import About from './pages/About.vue';
import Login from './pages/Login.vue';
import Register from './pages/Cadastro.vue';
import Profile from './pages/Profile.vue';
import Diarios from './pages/Diarios.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/sobre',
            name: 'sobre',
            component: About
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/registrar',
            name: 'registrar',
            component: Register
        },
        {
            path: '/perfil',
            name: 'perfil',
            component: Profile
        },
        {
            path: '/diarios',
            name: 'diarios',
            component: Diarios
        }
    ]
});

export default router;
