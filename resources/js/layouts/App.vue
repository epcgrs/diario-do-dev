<template>
  <div>
    <header-nav>
    </header-nav>
    <div class="container">
      <router-view>
      </router-view>
    </div>
  </div>
</template>

<script>
import headerNav from '../components/Header.vue';

export default {
    components: {
        headerNav
    },
    watch: {
        $route() {
            $("#navbarCollapse").collapse("hide");
        },
    },
    mounted() {
        let currentTheme = this.$store.getters.appColorTheme;

        this.$store.commit('setColorTheme', {theme: currentTheme});
    }
};
</script>
