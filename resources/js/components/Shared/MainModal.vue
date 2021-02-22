<template>
    <div class="modal fade show" ref="mainModal" data-backdrop="static"
         data-keyboard="false" tabindex="-1" aria-labelledby="mainModalLabel" aria-modal="true"
         style="display: block;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" v-bind:class="(!!size) ? 'modal-' + size : 'modal-lg'">
            <div class="modal-content">
                <form autocomplete="off" @submit.prevent="handleSubmit">
                    <div class="modal-header">
                        <h5 class="modal-title text-bold" id="mainModalLabel">
                            <slot name="header"></slot>
                        </h5>
                        <button type="button" @click="$emit('closed')" class="close"
                                data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['size'],
    methods: {
        handleSubmit(){
            this.$emit('submitted');
        }
    }
}
</script>

<style scoped>
    .modal-dialog-scrollable .modal-content {
        border: 0;
        border-radius: 0;
        overflow-y: auto;
    }
</style>
