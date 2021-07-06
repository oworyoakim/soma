<template>
    <!-- Forgot Password Tab Content -->
    <div class="login-right">
        <div class="login-header text-center">
            <h2 class="mb-2">Forgot Password?</h2>
            <p class="text-muted">Enter your email to get a password reset link</p>
        </div>
        <!-- Forgot Password Form -->
        <form action="#">
            <div class="form-group">
                <label class="form-control-label">Email Address</label>
                <input type="email" class="form-control">
            </div>
            <button class="btn btn-primary login-btn" type="submit">Reset Password</button>
            <div class="text-center mt-3">
                <a class="forgot-link" href="/login">Remembered your password?</a>
            </div>
        </form>
        <!-- /Forgot Password Form -->
    </div>
    <!-- /Forgot Password Tab Content -->
</template>

<script>
export default {}
</script>

<style scoped>

</style>
