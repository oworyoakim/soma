<template>
    <div class="header-fixed">
        <nav class="navbar navbar-expand-lg header-nav">
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
                </a>
                <a href="/" class="navbar-brand logo">
                    <img src="/images/logo.png" class="img-fluid" alt="Logo">
                </a>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="/" class="menu-logo">
                        <img src="/images/logo.png" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <ul class="main-nav">
                    <li class="has-submenu"
                        v-bind:class="$store.getters.IS_ACTIVE_PATH(['/courses','/courses/primary','/courses/lower-secondary','/courses/upper-secondary']) ? 'active': ''">
                        <a href="/courses">Lessons<i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li v-bind:class="$store.getters.IS_ACTIVE_PATH(['/courses/primary']) ? 'disabled active': ''">
                                <a href="/courses/primary">Primary</a>
                            </li>
                            <li v-bind:class="$store.getters.IS_ACTIVE_PATH(['/courses/lower-secondary']) ? 'disabled active': ''">
                                <a href="/courses/lower-secondary">Lower Secondary</a>
                            </li>
                            <li v-bind:class="$store.getters.IS_ACTIVE_PATH(['/courses/upper-secondary']) ? 'disabled active': ''">
                                <a href="/courses/upper-secondary">Upper Secondary</a>
                            </li>
                        </ul>
                    </li>
                    <li v-bind:class="$store.getters.IS_ACTIVE_PATH(['/instructors']) ? 'disabled active': ''">
                        <a href="/instructors">Instructors</a>
                    </li>
                </ul>
            </div>
            <ul class="nav header-navbar-rht">
                <template v-if="$store.getters.IS_LOGGED_IN">
                    <!-- User Menu -->
                    <li class="nav-item dropdown has-arrow logged-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
									<img class="rounded-circle" src="/images/avatar.png" width="31" alt="Darren Elder">
								</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="user-header">
                                <div class="avatar avatar-sm">
                                    <img src="/images/avatar.png" alt="User Image" class="avatar-img rounded-circle">
                                </div>
                                <div class="user-text">
                                    <h6>Jonathan Doe</h6>
                                    <p class="text-muted mb-0">Mentor</p>
                                </div>
                            </div>
                            <a class="dropdown-item" href="#">Dashboard</a>
                            <a class="dropdown-item" href="#">Profile Settings</a>
                            <a @click="logout()" class="dropdown-item" href="javascript:void(0);">Logout</a>
                        </div>
                    </li>
                    <!-- /User Menu -->
                </template>
                <template v-else>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link header-login" href="/signup">Register</a>
                    </li>
                </template>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
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
