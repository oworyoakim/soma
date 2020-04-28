<template>
    <v-app id="inspire">
        <v-progress-linear v-if="isLoading" height="8" background-opacity="0.3" indeterminate top/>
        <template v-else>
            <app-nav-bar-module v-if="activeWindow === 'module'  && !!activeModule"/>
            <app-nav-bar v-else/>
            <v-content>
                <v-container fluid fill-height>
                    <router-view></router-view>
                </v-container>
            </v-content>
            <app-toast/>
        </template>
    </v-app>
</template>

<script>

    import {mapGetters} from "vuex";

    export default {
        created() {
            this.getUserData();
        },
        computed: {
            ...mapGetters({
                activeWindow: 'ACTIVE_WINDOW',
                activeModule: 'ACTIVE_MODULE',
            }),
        },
        data() {
            return {
                isLoading: false,
        }
        },
        methods: {
            async getUserData() {
                try {
                    this.isLoading = true;
                    await this.$store.dispatch('GET_LOGGED_IN_USER');
                    this.isLoading = false;
                } catch (error) {

                }
            }
        }
    }
</script>

<style scoped>

</style>
