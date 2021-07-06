<template>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="far fa-clock"></i></span>
        </div>
        <input type="text"
               class="form-control float-right"
               :value="dateRange"
               ref="dateTimeRangePicker"
               id="dateTimeRangePicker">
    </div>
</template>

<script>
export default {
    props: {
        config: Object,
        value: '',
        hasErrors: Boolean,
    },
    mounted() {
        this.dateRange = String(this.value);
        new this.$DateRangePicker(this.$refs.dateTimeRangePicker, {autoUpdateInput: false, ...this.config}, this.handleChange);
    },
    data() {
        return {
            dateRange: '',
        };
    },
    methods: {
        handleChange(startDate, endDate) {

            if (this.config.singleDatePicker) {
                if (this.config.timePicker) {
                    this.dateRange = startDate.format(this.config.locale.format || 'YYYY-MM-DD HH:mm');
                } else {
                    this.dateRange = startDate.format(this.config.locale.format || 'YYYY-MM-DD');
                }
            } else {
                if (this.config.timePicker) {
                    this.dateRange = startDate.format(this.config.locale.format || 'YYYY-MM-DD HH:mm') + ' - ' + endDate.format(this.config.locale.format || 'YYYY-MM-DD HH:mm');
                } else {
                    this.dateRange = startDate.format(this.config.locale.format || 'YYYY-MM-DD') + ' - ' + endDate.format(this.config.locale.format || 'YYYY-MM-DD');
                }
            }
            this.$emit('input', this.dateRange);
        }
    }
}
</script>
