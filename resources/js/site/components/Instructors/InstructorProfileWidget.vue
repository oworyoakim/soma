<template>
    <div class="profile-widget">
        <div class="user-avatar">
            <a href="#">
                <img class="img-fluid" alt="User Image" src="/img/user/user.jpg">
            </a>
            <a href="javascript:void(0)" class="fav-btn">
                <i class="far fa-bookmark"></i>
            </a>
        </div>
        <div class="pro-content">
            <h3 class="title">
                <a href="#">Ruby Perrin</a>
                <i class="fas fa-check-circle verified"></i>
            </h3>
            <p class="speciality">Digital Marketer</p>
            <div class="rating">
                <i class="fas fa-star filled"></i>
                <i class="fas fa-star filled"></i>
                <i class="fas fa-star filled"></i>
                <i class="fas fa-star filled"></i>
                <i class="fas fa-star filled"></i>
                <span class="d-inline-block average-rating">(17)</span>
            </div>
            <ul class="available-info">
                <li>
                    <i class="fas fa-map-marker-alt"></i> Florida, USA
                </li>
                <li>
                    <i class="far fa-clock"></i> Available on Fri, 22 Mar
                </li>
                <li>
                    <i class="far fa-money-bill-alt"></i> $300 - $1000 <i class="fas fa-info-circle" data-toggle="tooltip" title="Lorem Ipsum"></i>
                </li>
            </ul>
            <div class="row row-sm">
                <div class="col-6">
                    <a href="#" class="btn view-btn">View Profile</a>
                </div>
                <div class="col-6">
                    <a href="#" class="btn book-btn">Book Now</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {}
</script>

<style scoped>

</style>
