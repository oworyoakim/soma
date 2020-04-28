<template>
    <div class="row ml-2">
        <div class="col-md-3">
            <v-card class="row">
                <div class="col-md-3 col-sm-6 text-center">
                    <v-avatar color="green">
                        <v-icon dark x-large size="100">{{icon}}</v-icon>
                    </v-avatar>
                </div>
                <div class="col-md-9 col-sm-6 text-center">
                    <h2>{{num}}</h2>
                    <h5>{{text}}</h5>
                </div>
            </v-card>
        </div>
        <div class="col-md-3">

        </div>
        <div class="col-md-3">

        </div>
        <div class="col-md-3">

        </div>
    </div>
</template>

<script>
    export default {
        props: {
            icon: String,
            text: String,
            num: String,
        }
    }
</script>

<style scoped>

</style>
