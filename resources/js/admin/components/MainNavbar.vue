<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <div class="container-fluid">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link"
                       data-widget="pushmenu"
                       href="#"
                       role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item" v-if="title">
                    <a class="nav-link" href="javascript:void(0);">{{title}}</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" v-if="$store.getters.IS_LOGGED_IN">
                    <a class="nav-link"
                       @click="logout()"
                       data-widget="control-sidebar"
                       href="javascript:void(0)"
                       role="button">
                        <i class="fas fa-power-off"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "MainNavbar",
        props: ['title'],
        methods: {
            async logout() {
                try {
                 let response = await this.$store.dispatch("LOGOUT");
                    this.$store.dispatch("SET_SNACKBAR", {message: response});
                    location.reload();
                } catch (error) {
                    console.error(error);
                    this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                }
            }
        }
    }
</script>

<style scoped>

</style>
