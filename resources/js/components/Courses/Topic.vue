<template>
    <v-layout row wrap>
            <v-flex md6>
                <h1>{{activeTopic.title}}</h1>
                <v-card class="ma-3" flat v-if="material.type === 'video'">
                    <app-video-player :src="material.path" />
                </v-card>
            </v-flex>
    </v-layout>
</template>