<template>
    <div>
        <v-navigation-drawer v-model="drawer" app dark class="blue-grey darken-1">
            <v-list flat nav>
                <v-list-item>
                    <v-list-item-avatar @click="backToCourse()">
                        <v-icon>skip_previous</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>{{module.title}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item @click="setActiveTopic(null)" v-bind:class="{grey: !activeTopic}">
                    <v-list-item-action>
                        <v-icon>star</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Overview</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item v-for="topic in module.topics" :key="topic.id" @click="setActiveTopic(topic)" v-bind:class="{grey: activeTopic && activeTopic.id == topic.id}">
                    <v-list-item-action>
                        <v-icon>star</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{topic.title}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <template v-slot:append>
                <v-divider></v-divider>
            </template>
        </v-navigation-drawer>
        <v-app-bar app absolute class="blue-grey darken-1">
            <v-icon color="white" @click.stop="drawer = !drawer">menu</v-icon>
            <v-spacer></v-spacer>
            <span v-if="activeTopic" class="align-center white--text">{{activeTopic.title}}</span>
            <span v-else class="align-center white--text">Overview</span>
            <v-spacer></v-spacer>
        </v-app-bar>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import {EventBus} from "../app";

    export default {
        computed: {
            ...mapGetters({
                module: 'ACTIVE_MODULE',
                course: 'ACTIVE_COURSE',
            }),
        },
        data() {
            return {
                drawer: true,
                activeTopic: null,
            }
        },
        methods: {
            backToCourse() {
                this.$store.dispatch('SET_ACTIVE_MODULE', null);
                this.$store.dispatch('SET_ACTIVE_WINDOW', 'main');
                this.$router.push({
                    name: 'course-details',
                    params: {slug: this.course.slug}
                });
            },
            setActiveTopic(topic) {
                this.activeTopic = topic;
                EventBus.$emit("TOPIC", topic);
            }
        }
    }
</script>

<style scoped>

</style>
