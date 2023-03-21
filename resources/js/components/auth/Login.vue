<template>
  <div class="row justify-content-center mt-5 position-absolute top-50 start-50 translate-middle">
    <div class="col-md-6">
      <div class="authincation-content">
        <div class="row no-gutters">
          <div class="col-xl-12">
            <div class="auth-form">
              <p class="brand-logo c-pointer text-center">
                <img src="/images/inspiro-logo.png" alt="Inspiro" />
              </p>
              <h4 class="text-center mb-4">Sign in your account</h4>
              <form action="./index">
                <div class="form-group">
                  <label class="mb-1"><strong>Email</strong></label>
                  <input
                    v-model="credentials.email"
                    type="email"
                    class="form-control"
                    :placeholder="placeholder[0]"
                  />
                  <div class="invalid-feedback ml-2">
                    <ul>
                      <li v-for="(error, index) in errors.email" :key="index"><span>{{ error }}</span></li>
                    </ul>
                  </div>
                </div>
                <div class="form-group">
                  <label class="mb-1"><strong>Password</strong></label>
                  <input
                    v-model="credentials.password"
                    type="password"
                    class="form-control"
                    :placeholder="placeholder[1]"
                  />
                </div>
                <div class="form-row d-flex justify-content-between mt-4 mb-2">
                  <div class="form-group">
                    <div class="custom-control custom-checkbox ml-1">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="basic_checkbox_1"
                      />
                      <label class="custom-control-label" for="basic_checkbox_1"
                        >Remember me</label
                      >
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button
                    @click.prevent="authenticate"
                    type="submit"
                    class="btn btn-primary btn-block"
                  >
                    Sign Me In
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data: () => ({
    credentials: {
      email: "",
      password: "",
    },
    placeholder: ["email@email.com", "password"],
  }),
  methods: {
    ...mapActions("auth", ["login", "resetError"]),
    ...mapActions("navigation", ["urlPush"]),
    authenticate() {
      this.login(this.credentials);
    },
  },
  computed: {
    ...mapGetters("auth", ["getToken", "isAuthenticated", "errors"]),
  },
  watch: {
    isAuthenticated: function (val) {
      if (val) {
        let nav = {
          label: "Dashboard",
          icon: "bi bi-house-fill",
          isActive: true,
          url: "/home",
        };
        this.urlPush(nav);
        this.$router.go({ path: "/home" });
      } else {
        console.log("loglog");
      }
    },
  },
  mounted() {
    this.resetError();
  },
};
</script>

<style scoped>
.invalid-feedback{
  display: block;
}
</style>
