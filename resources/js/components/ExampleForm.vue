<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{ title }}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <h3>The form goes here!</h3>
            </form>
        </template>
        <template slot="footer">
            <button @click="save()"
                    type="submit"
                    :disabled="formInvalid"
                    class="btn btn-info btn-block">
                <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                <span v-else>Submit</span>
            </button>
        </template>
    </MainModal>
</template>

<script>
import MainModal from "./Shared/MainModal";

export default {
    components: {MainModal},
    created() {
        EventBus.$on('EDIT', this.edit);
    },
    data() {
        return {
            isEditing: false,
            isSending: false,
        }
    },
    computed: {
        title() {
            return "Create or Edit Form";
        },
        formInvalid() {
            return this.isSending;
        }
    },
    methods: {
        edit() {
            this.isEditing = true;
        },
        async save() {
            try {

            } catch (error) {
                this.isSending = false;
                this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
            }
        },
        resetForm() {
            this.isEditing = false;
        },
    }
}
</script>

<style scoped>

</style>
