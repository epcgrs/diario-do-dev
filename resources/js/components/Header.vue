<template>
    <b-navbar toggleable="lg" type="dark" variant="info">
        <b-container>
            <b-row align-v="center" align-h="between" class="w-100">
                <b-col cols="12" class="navbar navbar-dark bg-info navbar-expand-lg">

                    <b-navbar-brand :to="{ name: 'home' }" >Diario de um dev</b-navbar-brand>

                    <b-navbar-nav>
                        <b-nav-item :to="{ name: 'diarios' }">Diários</b-nav-item>
                        <b-nav-item :to="{ name: 'sobre' }">Sobre</b-nav-item>
                    </b-navbar-nav>

                    <!-- Right aligned nav items -->
                    <b-navbar-nav class="ml-auto">
                        <b-nav-item @click="toggleTheme">
                            <b-icon v-if="currentThemeName == 'light'" icon="moon"></b-icon>
                            <b-icon v-else icon="sun"></b-icon>
                        </b-nav-item>
                        <b-nav-item-dropdown v-if="loggIn" right>
                            <!-- Using 'button-content' slot -->
                            <template #button-content>

                                {{ loggIn && userData ? userData.name.split(' ')[0] : 'Erro' }}
                            </template>
                            <b-dropdown-item :to="{ name: 'perfil' }">Perfil</b-dropdown-item>
                            <b-dropdown-item @click="logout">Sair</b-dropdown-item>
                        </b-nav-item-dropdown>
                        <b-nav-item-dropdown v-else right>
                            <!-- Using 'button-content' slot -->
                            <template #button-content>
                                Ações
                            </template>
                            <b-dropdown-item :to="{ name: 'registrar' }">Cadastrar</b-dropdown-item>
                            <b-dropdown-item :to="{ name: 'login' }">Entrar</b-dropdown-item>
                        </b-nav-item-dropdown>

                    </b-navbar-nav>

                </b-col>
            </b-row>
        </b-container>
    </b-navbar>
</template>
<script>
export default {
    name: "headerNav",
    data() {
        return {
            user: [],
        }
    },
    computed: {
        loggIn() {
            return this.$store.state.auth.status.loggedIn;
        },
        userData() {
            return this.$store.state.auth.user;
        },
        currentThemeName() {
            return this.$store.state.settings.colorTheme;
        }
    },
    methods: {
        logout() {
            this.$store.dispatch('auth/logout').then(response => {
                this.userLogged = this.$store.getters['auth/userLoggedIn']
                this.user = null
                this.$router.push('/')
                this.$forceUpdate()
            }).catch(err => {
                this.$toast.open({
                    message: "Seu logout pode não ter funcionado",
                    type: 'error',
                    position: 'top-right',
                    duration: 4000
                });
            });
        },
        toggleTheme() {
            if (this.$store.getters.appColorTheme === 'light') {
                return this.$store.commit('setColorTheme', {theme: 'dark'});
            }
            return this.$store.commit('setColorTheme', {theme: 'light'});
        }
    },
    mounted() {
        if( this.$store.getters['auth/userLoggedIn'] ) {
            this.user = this.$store.getters['auth/userData']
        }
    }
};
</script>
