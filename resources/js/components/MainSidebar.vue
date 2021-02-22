<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4 small">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="/images/logo.png" alt="SOMA" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">SOMA</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/images/avatar.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Admin</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="/admin/dashboard"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin','/admin/dashboard']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['programs','programs.create','programs.update'])">
                        <a href="/admin/programs"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/programs']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-procedures"></i>
                            <p>Manage Programs <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>

                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['enrollments','enrollments.create','enrollments.update'])">
                        <a href="/admin/enrollments"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/enrollments']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-registered"></i>
                            <p>Manage Enrollments <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['levels','levels.create','levels.update'])">
                        <a href="/admin/levels"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/levels']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>Manage Levels <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['intakes','intakes.create','intakes.update'])">
                        <a href="/admin/intakes"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/intakes']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-university"></i>
                            <p>Manage Intakes <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['courses','courses.create','courses.update'])">
                        <a href="/admin/courses"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/courses']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Manage Courses <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['live-classes','live-classes.create','live-classes.update'])">
                        <a href="/admin/live-classes"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/live-classes']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-video"></i>
                            <p>Manage Live Classes <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['exams','exams.create','exams.update'])">
                        <a href="/admin/exams"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/exams']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-question"></i>
                            <p>Manage Exams <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['students','students.create','students.update'])">
                        <a href="/admin/students"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/students']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>Manage Students <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['instructors','instructors.create','instructors.update'])">
                        <a href="/admin/instructors"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/instructors']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-book-reader"></i>
                            <p>Manage Instructors <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item"
                        v-if="$store.getters.HAS_ANY_ACCESS(['logbooks','logbooks.create','logbooks.update'])">
                        <a href="/admin/logbooks"
                           class="nav-link"
                           v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/logbooks']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>Manage Logbooks <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item" v-if="$store.getters.HAS_ANY_ACCESS(['users','users.create','users.update'])">
                        <a href="/admin/users"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/users']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Manage Users <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/roles"
                                     class="nav-link"
                                     v-bind:class="$store.getters.IS_ACTIVE_PATH(['/admin/roles']) ? 'disabled active': ''">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>Manage Roles <i class="right fas fa-angle-left"></i></p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    export default {}
</script>

<style scoped>

</style>
