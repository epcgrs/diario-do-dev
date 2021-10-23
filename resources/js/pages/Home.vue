<template>
    <div class="container mt-5">
        <div class="loader d-flex justify-contents-center align-items-center vh-50" v-if="loading">
            <div class="d-block m-auto">
                <hexagon size="100px"></hexagon>
            </div>
        </div>
        <div class="row list-of-contents-home" v-else>

            <div v-if="user.type === 'master'" class="mb-3">
                <b-button to="create-content" class="ml-3">
                    Criar Conteúdo
                </b-button>
            </div>

            <template v-if="contents">
                <div v-for="(content, index) in contents" :class="{'col-md-12': index === 0, 'col-md-4 mt-4': index !== 0 }">
                    <template v-if="index === 0">
                        <div class="content-wrapper d-flex">
                            <div class="image-block-featured">
                                <img src="https://picsum.photos/800/600" class="img-fluid image-featured" :alt="content.title">
                            </div>
                            <div class="content-block-featured">
                                <h3>{{content.title}}</h3>
                                <p>{{content.excerpt}}</p>
                                <a href="#" class="button-site-primary">Ver mais</a>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="content-wrapper">
                            <div class="image-wrapper">
                                <img src="https://picsum.photos/400" class="img-fluid simple-image" :alt="content.title">
                            </div>
                            <div class="content-block-simple">
                                <h3>{{content.title}}</h3>
                                <p class="mt-3">{{content.excerpt}}</p>
                                <a href="#" class="button-site-primary">Ver mais</a>
                            </div>
                        </div>
                    </template>

                </div>
            </template>

            <template v-else>
                <p>
                    sem conteúdos
                </p>
            </template>

        </div>
    </div>
</template>

<script>
import Hexagon from 'vue-loading-spinner/src/components/Hexagon';

export default {
    name: 'home',
    components: {
        Hexagon
    },
    data() {
       return {
           contents: null,
           loading: false,
           user: []
       }
    },
    methods: {
        fetchHomeContents() {
            this.loading = true;
            this.$store.dispatch('contents/homeContent').then(response => {
                this.contents = response.data.contents.data;

            }).then(() => this.loading = false);
        },
        verifyResponseLogin() {
            const queryString = window.location.search
            if(queryString.length) {
                const urlParams = new URLSearchParams(queryString);
                const response = urlParams.get('response');
                if(response) {
                    const responseJson = JSON.parse(response);

                    const { token, user } = responseJson;

                    localStorage.setItem('user', JSON.stringify( user ));
                    localStorage.setItem('token', token);

                    window.location.href = window.location.href.split('?')[0];
                }
            }

        }
    },
    mounted() {
        this.fetchHomeContents();
        this.verifyResponseLogin();

        if( this.$store.getters['auth/userLoggedIn'] ) {
            this.user = this.$store.getters['auth/userData']
        }
    }
}
</script>
