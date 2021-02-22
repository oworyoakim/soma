<template>
    <div class="container-fluid pt-2">
        <Spinner v-if="isLoading" />
        <template v-else-if="activeUser">

        </template>
        <template v-else>
            <UsersList />
        </template>
        <UserForm />
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import UsersList from "./UsersList";
import UserForm from "./UserForm";

export default {
    components: {UserForm, UsersList},
    props: ['title'],
    created() {
        this.getUsers().then(() => {
            this.$store.dispatch("GET_ROLES");
        }).catch((error) => {
            console.log(error);
            this.$store.dispatch('SET_SNACKBAR', {
                message: error,
                context: 'error',
            });
        });
    },
    computed: {
        ...mapGetters({
            activeUser: 'ACTIVE_USER',
            isLoading: 'LOADING',
        }),
    },
    methods: {
        getUsers() {
            return this.$store.dispatch('GET_USERS');
        },
    }
}
</script>

<style scoped>

</style>
