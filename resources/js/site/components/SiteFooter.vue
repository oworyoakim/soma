<template>
    <div>
        <!-- Footer Top -->
        <div class="footer-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-menu">
                            <h2 class="footer-title">Useful Links</h2>
                            <ul class="mt-0">
                                <li><a href="/about-us">About Us</a></li>
                                <li><a href="/privacy-policy">Privacy Policy</a></li>
                            </ul>
                        </div>
                        <!-- /Footer Widget -->

                    </div>

                    <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-menu">
                            <h2 class="footer-title">For Learners</h2>
                            <ul class="mt-0">
                                <li><a href="/courses">Browse Courses</a></li>
                                <li><a href="/instructors">Search Instructors</a></li>
                                <li><a href="/login">Login</a></li>
                                <li><a href="/signup">Register</a></li>
                                <li><a href="/dashboard">Your Dashboard</a></li>
                            </ul>
                        </div>
                        <!-- /Footer Widget -->

                    </div>
                    <div class="col-lg-3 col-md-6">

                        <!-- Footer Widget -->
                        <div class="footer-widget footer-menu">
                            <h2 class="footer-title">For Instructors</h2>
                            <ul>
                                <li><a href="/instructor-courses">Your Courses</a></li>
                                <li><a href="/login">Login</a></li>
                                <li><a href="/instructor-signup">Register</a></li>
                                <li><a href="/instructor-dashboard">Your Dashboard</a></li>
                            </ul>
                        </div>
                        <!-- /Footer Widget -->

                    </div>
                    <div class="col-lg-3 col-md-6">

                        <!-- Footer Widget -->
                        <div class="footer-widget footer-contact">
                            <h2 class="footer-title">Contact Us</h2>
                            <p class="mt-0">Contrary to popular belief, Lorem simply random text. It has roots in a piece of classical Latin literature.</p>
                            <div class="footer-contact-info">
                                <div class="footer-address">
                                    <span><i class="fas fa-map-marker-alt"></i></span>
                                    <p> Plot 1234  Nakasero Road, Kampala,<br> Uganda, 2568088 </p>
                                </div>
                                <p>
                                    <i class="fas fa-phone-alt"></i>
                                    +256312000000
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-envelope"></i>
                                    mentoring@soma.kim
                                </p>
                            </div>
                        </div>
                        <!-- /Footer Widget -->

                    </div>
                </div>
            </div>
        </div>
        <!-- /Footer Top -->
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container-fluid">
                <!-- Copyright -->
                <div class="copyright">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="copyright-text">
                                <p class="mb-0 text-white">&copy; {{$moment().format('YYYY')}} Mentoring. All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Copyright -->
            </div>
        </div>
        <!-- /Footer Bottom -->
    </div>
</template>

<script>
export default {}
</script>

<style scoped>

</style>
