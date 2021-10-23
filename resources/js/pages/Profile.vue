<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Perfil</div>

                    <div class="card-body">
                        <p>
                            Nome: {{user.name}}
                        </p>

                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: [],
        }
    },
    mounted() {
        if( this.$store.getters['auth/userLoggedIn'] ) {
            this.user = this.$store.getters['auth/userData']
        }
    }
}
</script>
