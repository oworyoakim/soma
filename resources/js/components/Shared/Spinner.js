import Vue from 'vue';

export default Vue.component('Spinner', {
    template: '<span class="fa fa-spinner fa-spin" v-bind:class="size"></span>',
    props: {
        size: ""
    }
});
