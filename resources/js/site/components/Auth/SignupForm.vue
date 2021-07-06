<template>
    <!-- Register Content -->
    <div class="login-right">
        <div class="login-header text-center">
            <p class="small">
                <a href="/" class="navbar-brand logo">
                    <img src="/images/logo.png" class="img-fluid img-rounded" height="50">
                </a>
            </p>
            <h2>Create your free Account!</h2>
        </div>
        <!-- Register Form -->
        <form @submit.prevent="registerAccount()" autocomplete="off">
            <div class="form-group">
                <label class="form-control-label">First Name</label>
                <input type="text" v-model="credentials.firstName" class="form-control" autofocus :readonly="isSending">
            </div>
            <div class="form-group">
                <label class="form-control-label">Last Name</label>
                <input type="text" v-model="credentials.lastName" class="form-control" :readonly="isSending">
            </div>
            <div class="form-group">
                <label class="form-control-label">Email Address</label>
                <input type="email" v-model="credentials.loginName" class="form-control" :readonly="isSending">
            </div>
            <div class="form-group">
                <label class="form-control-label">Password</label>
                <input type="password" v-model="credentials.loginPassword" class="form-control" :readonly="isSending">
            </div>
            <div class="form-group">
                <label class="form-control-label">Confirm Password</label>
                <input type="password" v-model="credentials.loginPasswordConfirmation" class="form-control"
                       :readonly="isSending">
            </div>
            <div class="form-group">
                <div class="checkbox-inline">
                    <input type="checkbox" v-model="credentials.privacyPolicyAccepted" class="checkbox"
                           :readonly="isSending">
                    <label class="form-control-label">I agree to Mentoring <a href="javascript:void(0);"
                                                                              class="text-bold text-underline">Data
                        Privacy Policy</a></label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary login-btn" :disabled="formInvalid">
                <Spinner v-if="isSending"/>
                <template v-else>Create Account</template>
            </button>
            <div class="account-footer text-center mt-3">
                Already have an account? <a v-if="!isSending" class="forgot-link mb-0" href="/login">Login</a>
            </div>
        </form>
        <!-- /Register Form -->
    </div>
    <!-- /Register Content -->
</template>

<script>
import Spinner from "../../../shared/components/Spinner";

export default {
    components: {
        Spinner,
    },
    data() {
        return {
            isSending: false,
            credentials: {
                firstName: '',
                lastName: '',
                loginName: '',
                loginPassword: '',
                loginPasswordConfirmation: '',
                privacyPolicyAccepted: false,
            }
        }
    },
    computed: {
        formInvalid() {
            return this.isSending || !this.credentials.privacyPolicyAccepted;
        },
    },
    methods: {
        async registerAccount() {
            this.isSending = true;
        },
    }
}
</script>

<style scoped>

</style>
