<template>
    <MainModal v-if="isEditing" @closed="resetForm()">
        <template slot="header">{{title}}</template>
        <template slot="body">
            <form autocomplete="off" novalidate>
                <div class="form-group row">
                    <label class="col-md-3">Name</label>
                    <div class="col-md-9">
                        <input v-model="level.title"
                               class="form-control"
                               type="text"
                               placeholder="Level name"
                               required>
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button type="button"
                    @click="saveLevel()"
                    :disabled="formInvalid"
                    class="btn btn-info btn-block">
                <span v-if="isSending" class="fa fa-spinner fa-spin"></span>
                <span v-else>Submit</span>
            </button>
        </template>
    </MainModal>
</template>

<script>
    import {deepClone} from "../../../utils/helpers";
    import Level from "../../../models/Level";
    import MainModal from "../../Shared/MainModal";

    export default {
        components: {MainModal},
        created() {
            EventBus.$on('EDIT_LEVEL', this.editLevel);
        },
        data() {
            return {
                level: new Level(),
                isEditing: false,
                isSending: false,
            }
        },
        computed: {
            title() {
                return (!!this.level.id) ? "Edit Level" : "New Level";
            },
            formInvalid() {
                return this.isSending || !(!!this.level.title);
            }
        },
        methods: {
            editLevel(level = null) {
                if (level) {
                    this.level = deepClone(level);
                } else {
                    this.level = new Level();
                }
                this.isEditing = true;
            },
            async saveLevel() {
                try {
                    let response = await this.$store.dispatch("SAVE_LEVEL", this.level);
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: response});
                    EventBus.$emit("LEVEL_SAVED");
                    this.resetForm();
                } catch (error) {
                    this.isSending = false;
                    this.$store.dispatch("SET_SNACKBAR", {message: error, context: 'error'});
                }
            },
            resetForm() {
                this.level = new Level();
                this.isEditing = false;
            }
        }
    }
</script>

<style scoped>

</style>
