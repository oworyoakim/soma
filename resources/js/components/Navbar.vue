<template>
    <div>
        <v-navigation-drawer v-model="drawer" app dark class="indigo darken-1">
            <v-list>
                <v-list-item>
                    <v-list-item-avatar>
                        <img v-if="!!user" :src="user.avatar"/>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title v-if="user">
                            {{ user.username }}
                        </v-list-item-title>
                        <v-list-item-subtitle v-if="!!user.role">
                            {{ role.name }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item
                    v-for="link in links"
                    :to="link.route"
                    :key="link.route"
                >
                    <v-list-item-action>
                        <v-icon>{{ link.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{ link.text }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <template v-slot:append>
                <v-divider></v-divider>
            </template>
        </v-navigation-drawer>
        <v-app-bar app absolute class="indigo darken-1">
            <v-icon @click.stop="drawer = !drawer" dark>mdi-menu</v-icon>
            <v-spacer></v-spacer>
            <v-btn @click="logout()" icon color="white" class="mr-5 text-none">
                <v-icon>mdi-power</v-icon>
                Logout
            </v-btn>
        </v-app-bar>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        computed: {
            ...mapGetters({
                user: "LOGGED_IN_USER"
            }),
            links() {
                if (this.user && this.user.isStudent) {
                    return [
                        {route: "/", text: "Dashboard", icon: "mdi-home"},
                        {route: "/my-courses", text: "My Courses", icon: "mdi-library-books"},
                    ]
                }
                return [
                    {route: "/admin/courses", text: "Admin Courses", icon: "mdi-library-books"},
                    {route: "/admin/exam", text: "Manage Exam", icon: "mdi-head-question-outline"},
                    {route: "/admin/users", text: "Manage Users", icon: "mdi-account-multiple"},
                    {route: "/admin/roles", text: "Manage Roles", icon: "mdi-account-group"},
                    {route: "/settings", text: "Settings", icon: "mdi-settings"},
                ];
            }
        },
        data() {
            return {
                drawer: true,
            };
        },
        methods: {
            async logout() {
                try {
                    let response = await this.$store.dispatch("LOGOUT");
                    //console.log(response);
                    this.$store.dispatch("SET_SNACKBAR", {
                        text: response,
                        context: "warning"
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } catch (error) {
                    console.log(error);
                }
            }
        }
    };
</script>

<style scoped></style>
