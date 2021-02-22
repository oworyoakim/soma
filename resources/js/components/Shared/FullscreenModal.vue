<template>
    <!-- Modal -->
    <div class="modal fade show"
         ref="fullScreenModal"
         tabindex="-1"
         role="dialog"
         aria-hidden="true"
         data-keyboard="false"
         style="display: block;">
        <!-- Full screen modal -->
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-bold">
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
.modal-fullscreen {
    width: 100vw;
    max-width: none;
    height: 100%;
    margin: 0;
}

.modal-fullscreen .modal-content {
    height: 100%;
    border: 0;
    border-radius: 0;
    overflow-y: auto;
}

.modal-fullscreen .modal-header {
    border-radius: 0;
}

.modal-fullscreen .modal-body {

}

.modal-fullscreen .modal-footer {
    border-radius: 0;
}
</style>
