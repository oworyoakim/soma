<template>
    <v-dialog v-model="isOpen" fullscreen hide-overlay transition="dialog-bottom-transition">
        <v-card flat>
            <v-toolbar dark :color="color || 'primary'">
                <v-btn class="ml-1" icon width="100px" rounded dark @click="closeModal">
                    <v-icon>mdi-close</v-icon>
                    Close
                </v-btn>
                <v-spacer></v-spacer>
                <v-card-title dark>{{title}}</v-card-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <slot></slot>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: {
            isOpen: {
                type: Boolean,
                default: false,
            },
            color: String,
            title: String
        },
        methods: {
            closeModal() {
                this.$emit("close-modal");
            }

        },
    }
</script>
