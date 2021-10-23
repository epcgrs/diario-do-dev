<template>
    <b-container class="mt-5">
        <b-row class="justify-content-center">
            <b-col cols="md-8">
                <b-card header="Cadastro" header-tag="header">
                    <ValidationObserver v-slot="{handleSubmit}">
                        <b-form @submit.prevent="handleSubmit(onSubmit)" id="register_form">

                                <b-form-group
                                    id="name-label"
                                    label="Nome:"
                                    label-for="name"
                                >
                                <ValidationProvider rules="required|min:3" v-slot="{ errors }" name="nome">
                                    <b-form-input
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        placeholder="Seu nome completo"
                                        name="name"
                                        :class="{'input': true, 'is-danger': errors.length }"
                                    ></b-form-input>
                                    <span class="invalid-feedback d-block">{{ errors[0] }}</span>
                                </ValidationProvider>
                                </b-form-group>

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
                                 <ValidationProvider :rules="{regex: /^(?=.*[a-zA-Z])(?=.*[0-9]).*$/, min:6, required: true}" v-slot="{ errors }" name="senha">
                                    <b-form-input
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        placeholder="Sua senha"
                                    ></b-form-input>
                                    <small>Deve conter pelo menos uma letra, pelo menos um número e ter no mínimo 6 caracteres</small>
                                    <span class="invalid-feedback d-block">{{ errors[0] }}</span>
                                </ValidationProvider>
                                </b-form-group>


                            <b-button variant="outline-primary" type="submit" form="register_form">Registrar</b-button>

                            <b-button variant="dark" @click="socialRegister">
                                Registrar com Github
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
    name: "cadastro",
    data() {
        return {
            form: {
                name: '',
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
            this.$store.dispatch('auth/register', this.form)
            .then(response => {
                this.$toast.open({
                    message: "Sucesso ao cadastrar! bora codar!",
                    type: 'success',
                    position: 'top-right',
                    duration: 4000
                });
                this.form = {
                    name: '',
                    email: '',
                    password: '',
                };
                this.$router.push('/perfil');
            }, err => {
                this.$toast.open({
                    message: "Erro ao tentar realizar cadastro",
                    type: 'error',
                    position: 'top-right',
                    duration: 4000
                });
            })
            .then(response => {
                this.loading = false;
            })
        },
        socialRegister() {
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
};
</script>
