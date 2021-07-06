<template>
    <section class="section path-section">
        <div class="section-header text-center">
            <div class="container-fluid">
                <span>Choose the</span>
                <h2>Different Learning Paths</h2>
                <p class="sub-title">Learn from the best teachers in the country while connecting and sharing knowledge
                    with your peers.</p>
            </div>
        </div>
        <Spinner v-if="isLoading"/>
        <template v-else>
            <div class="learning-path-col">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="large-col">
                                <a href="#" class="large-col-image">
                                    <div class="image-col-merge">
                                        <img src="/img/path-img1.jpg" alt="">
                                        <div class="text-col">
                                            <h5>Digital Marketer</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="large-col">
                                <a href="#" class="large-col-image">
                                    <div class="image-col-merge">
                                        <img src="/img/path-img2.jpg" alt="">
                                        <div class="text-col">
                                            <h5>Ui designer</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="large-col">
                                <a href="#" class="large-col-image">
                                    <div class="image-col-merge">
                                        <img src="/img/path-img3.jpg" alt="">
                                        <div class="text-col">
                                            <h5>IT Security</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="large-col">
                                <a href="#" class="large-col-image">
                                    <div class="image-col-merge">
                                        <img src="/img/path-img4.jpg" alt="">
                                        <div class="text-col">
                                            <h5>Front-End Developer</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="large-col">
                                <a href="#" class="large-col-image">
                                    <div class="image-col-merge">
                                        <img src="/img/path-img5.jpg" alt="">
                                        <div class="text-col">
                                            <h5>Web Developer</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="large-col">
                                <a href="#" class="large-col-image">
                                    <div class="image-col-merge">
                                        <img src="/img/path-img6.jpg" alt="">
                                        <div class="text-col">
                                            <h5>Administrator</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="large-col">
                                <a href="#" class="large-col-image">
                                    <div class="image-col-merge">
                                        <img src="/img/path-img7.jpg" alt="">
                                        <div class="text-col">
                                            <h5>Project Manager</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="large-col">
                                <a href="#" class="large-col-image">
                                    <div class="image-col-merge">
                                        <img src="/img/path-img8.jpg" alt="">
                                        <div class="text-col">
                                            <h5>PHP Developer</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </section>
</template>

<script>
import {mapGetters} from "vuex";
import Spinner from "../../../shared/components/Spinner";

export default {
    components: {Spinner,},
    data() {
        return {
            isLoading: false,
        }
    },
    computed: {
        ...mapGetters({
            learningPaths: "LEARNING_PATHS",
        }),
    },
    mounted() {
        this.getLearningPaths();
    },
    methods: {
        async getLearningPaths() {
            try {
                this.isLoading = true;
                await this.$store.dispatch("GET_LEARNING_PATHS");
                this.isLoading = false;
            } catch (error) {
                this.isLoading = false;
                await this.$store.dispatch("SET_SNACKBAR", {
                    message: error,
                    context: 'error'
                });
            }
        },
    },
}
</script>

<style scoped>

</style>
