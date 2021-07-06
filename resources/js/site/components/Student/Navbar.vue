<template>
    <nav class="main-header navbar navbar-expand-md navbar-dark navbar-light">
        <div class="container-fluid">
            <a href="/" class="navbar-brand">
                <img src="/images/logo.png" alt="SOMA"
                     class="brand-image img-circle elevation-3"
                     style="opacity: .8">
                <span class="brand-text font-weight-light">SOMA</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/student/dashboard"
                           class="nav-link"
                           v-bind:class="$store.getters.IS_ACTIVE_PATH(['/student','/student/dashboard']) ? 'active': ''">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="/student/courses"
                           class="nav-link"
                           v-bind:class="$store.getters.IS_ACTIVE_PATH(['/student/courses']) ? 'active': ''">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a href="/student/profile"
                           class="nav-link"
                           v-bind:class="$store.getters.IS_ACTIVE_PATH(['/student/profile']) ? 'active': ''">Profile</a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
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
        </div>
    </nav>
</template>

<script>
export default {
    name: "StudentNavbar",
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
