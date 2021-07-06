<template>
    <!-- Modal -->
    <div class="modal fade show" id="fullWidthModal" ref="fullWidthModal"
         tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
         aria-hidden="true" style="display: block;">
        <div class="modal-dialog mw-100 w-100 h-100 p-0 m-0">
            <div class="modal-content h-100 overflow-auto">
                <div class="modal-header">
                    <h5 class="modal-title text-bold" id="fullWidthModalLabel">
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
            </div>
        </div>
    </div>
</template>

<script>
export default {}
</script>

<style scoped>

</style>
