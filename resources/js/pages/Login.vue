<template>
    <b-container class="mt-5">
        <b-row class="justify-content-center">
            <b-col cols="md-8">
                <b-card header="Login" header-tag="header">
                    <ValidationObserver v-slot="{handleSubmit}">
                        <b-form @submit.prevent="handleSubmit(onSubmit)" id="login_form">


                            <b-form-group
                                id="email-label"
                                label="E-mail:"
                                label-for="email"
                            >
                                <ValidationProvider rules="required|min:3|email" v-slot="{ errors }" name="email">
                                    <b-form-input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        placeholder="Seu email"
                                    ></b-form-input>
                                    <span class="invalid-feedback d-block">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </b-form-group>

                            <b-form-group
                                id="password-label"
                                label="Senha:"
                                label-for="password"
                            >
                                <ValidationProvider rules="required" v-slot="{ errors }" name="senha">
                                    <b-form-input
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        placeholder="Sua senha"
                                    ></b-form-input>
                                    <span class="invalid-feedback d-block">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </b-form-group>


                            <b-button variant="outline-primary" type="submit" form="login_form">Login</b-button>

                            <b-button variant="dark" @click="socialLogin">
                                Login com Github
                                <b-icon icon="github"></b-icon>
                            </b-button>
                        </b-form>
                    </ValidationObserver>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
export default {
    name: "login",
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            loading: false,
        }
    },
    computed: {
        loggIn() {
            return this.$store.state.auth.status.loggedIn;
        }
    },
    methods: {
        onSubmit() {
            this.loading = true;
            this.$store.dispatch('auth/login', this.form)
                .then(response => {
                    if(!response.status) {
                        this.$toast.open({
                            message: response.message,
                            type: 'error',
                            position: 'top-right',
                            duration: 4000
                        });
                        return;
                    }

                    this.$toast.open({
                        message: "Sucesso ao entrar",
                        type: 'success',
                        position: 'top-right',
                        duration: 4000
                    });
                    this.form = {
                        email: '',
                        password: '',
                    };
                    this.$forceUpdate()
                    this.$router.push('/perfil');

                }, err => {
                    console.log(err);
                    this.$toast.open({
                        message: err.response.message,
                        type: 'error',
                        position: 'top-right',
                        duration: 4000
                    });
                })
                .then(response => {
                    this.loading = false;
                })
        },
        socialLogin() {
            this.$http.get('api/github-provider/redirect').then(
                (response) => {
                    window.location.href = response.data.url;
                },
                (err) => {
                    console.log(err);
                }
            )
        },
    },
}
</script>
