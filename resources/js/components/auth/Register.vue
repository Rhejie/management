<template>
  <div class="justify-content-center pt-5">
    <Breadcrumb />
    <div class="card">
      <div class="card-body px-5 pt-5">
        <div class="row mb-5 align-items-center">
          <label class="col-sm-2 col-form-label">Search Employee Name</label>
          <div class="col-sm">
            <model-list-select
              :list="employees"
              v-model="employee"
              option-value="id"
              option-text="name"
              placeholder="Select Employee"
            >
            </model-list-select>
          </div>
        </div>
        <!-- form -->
        <form v-if="credentials.employee_id" class="needs-validation" novalidate>
          <div class="mb-3 row align-items-center">
            <label class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm">
              <p class="form-control fs-3">{{ credentials.name }}</p>
              <div class="feedback" v-if="errors">
                <i v-for="error in errors.message.name" :key="error">{{
                  error
                }}</i>
              </div>
            </div>
          </div>

          <div class="mb-3 row align-items-center">
            <label class="col-sm-2 col-form-label">Email address</label>
            <div class="col-sm">
              <p class="form-control fs-3">{{ credentials.email }}</p>
              <div class="feedback" v-if="errors">
                <i v-for="error in errors.message.email" :key="error">{{
                  error
                }}</i>
              </div>
            </div>
          </div>

          <div class="mb-3 row align-items-center">
            <label class="col-sm-2 col-form-label">Role</label>
            <div class="col-sm">
              <model-list-select
                :list="roles"
                v-model="credentials.role_id"
                option-value="id"
                option-text="name"
                placeholder="Select Role"
              >
              </model-list-select>
            </div>
          </div>

          <div class="mb-3 row justify-content-md-end">
            <div class="col-auto">
              <div class="spinner-border" role="status" v-if="isLoading">
                <span class="visually-hidden">Loading...</span>
              </div>
              <button
                v-else
                @click.prevent="authenticate"
                type="submit"
                class="btn btn-primary mb-3"
              >
                Register
              </button>
            </div>
          </div>
        </form>
        <!-- end of form -->
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Breadcrumb from "../layouts/Breadcrumb.vue";
import { ModelListSelect } from "vue-search-select";

export default {
  components: {
    Breadcrumb,
    ModelListSelect,
  },
  data: () => ({
    search: "",
    employee: {},
    credentials: {
      employee_id: null,
      name: "",
      email: "",
      role_id: null,
      role_name: "",
    },
    isLoading: false,
    placeholder: ["my name is", "email@email.com"],
  }),
  methods: {
    ...mapActions("role", ["fetchRoles"]),
    ...mapActions("auth", ["register", "resetError"]),
    ...mapActions("proponent", ["fetchEmployeeList"]),
    authenticate() {
      this.isLoading = true;
      this.register(this.credentials).then(() => {
        if (!this.errors.error) {
          this.$router.push({ path: "/user-list" });
        }
      });
      this.isLoading = false;
    },
    getLabel(item) {
      return item.name;
    },
    updateItems(text) {
      console.log(text);
    },
  },
  computed: {
    ...mapGetters("role", ["roles"]),
    ...mapGetters("auth", ["errors", "getToken"]),
    ...mapGetters("proponent", ["employees"]),
    authHeaders() {
      return {
        Authorization: `Bearer ${this.getToken}`,
      };
    },
  },
  mounted() {
    this.fetchRoles();
    this.resetError();
    this.fetchEmployeeList();
  },
  watch: {
    employee: function (selectedEmployee) {
      if (selectedEmployee) {
        this.credentials = {
          employee_id: selectedEmployee.id,
          name: selectedEmployee.name,
          email: selectedEmployee.email,
        };
      }
    },
  },
};
</script>

<style scoped>
.feedback > i {
  width: 100%;
  margin-top: 0.25rem;
  font-size: 0.875em;
  color: #dc3545;
}

.ui.search.selection.dropdown > input.search,
.ui.search.selection.dropdown > span.sizer {
  line-height: 1.21428571em;
  padding: 0.67857143em 2.1em 0.67857143em 1em;
}
</style>
