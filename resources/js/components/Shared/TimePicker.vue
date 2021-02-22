<template>
    <div class="input-group date" ref="timePickerInput" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" :data-target="$refs.timePickerInput">
        <div class="input-group-append" :data-target="$refs.timePickerInput" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="far fa-clock"></i></div>
        </div>
    </div>
</template>

<script>
require('admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');
const DateTimePicker = require('admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min');
export default {
    mounted() {
        /*
        $(this.refs.timePickerInput).datetimepicker({
            format: 'LT'
        });
        */
        new DateTimePicker(this.refs.timePickerInput, {
            format: 'LT'
        });
    },
}
</script>

<style scoped>

</style>
