<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

                <!-- Search Filter -->
                <div class="card search-filter">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Search Filter</h4>
                    </div>
                    <div class="card-body">
                        <div class="filter-widget">
                            <h4>Gender</h4>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="gender_type" checked>
                                    <span class="checkmark"></span> Male
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="gender_type">
                                    <span class="checkmark"></span> Female
                                </label>
                            </div>
                        </div>
                        <div class="filter-widget">
                            <h4>Select Courses</h4>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="select_specialist" checked>
                                    <span class="checkmark"></span> Digital Marketer

                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="select_specialist" checked>
                                    <span class="checkmark"></span> UNIX, Calculus, Trigonometry
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="select_specialist">
                                    <span class="checkmark"></span> Computer Programming
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="select_specialist">
                                    <span class="checkmark"></span> ASP.NET,Computer Gaming
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="select_specialist">
                                    <span class="checkmark"></span> HTML, Css
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="select_specialist">
                                    <span class="checkmark"></span> VB, VB.net
                                </label>
                            </div>
                        </div>
                        <div class="btn-search">
                            <button type="button" class="btn btn-block">Search</button>
                        </div>
                    </div>
                </div>
                <!-- /Search Filter -->

            </div>

            <div class="col-md-12 col-lg-8 col-xl-9">
                <div class="row row-grid">
                    <div class="col-md-6 col-lg-4 col-xl-3" v-for="i in Array(8).keys()">
                        <!-- Instructor Widget -->
                        <InstructorProfileWidget/>
                        <!-- /Instructor Widget -->
                    </div>
                </div>

                <div class="blog-pagination mt-4">
                    <Pagination />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InstructorCard from "./InstructorCard";
import InstructorProfileWidget from "./InstructorProfileWidget";
import Pagination from "../Shared/Pagination";

export default {
    components: {Pagination, InstructorProfileWidget, InstructorCard}
}
</script>

<style scoped>

</style>
