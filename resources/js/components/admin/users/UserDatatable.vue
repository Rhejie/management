<template>
  <div class="pt-5">
    <div class="container-fluid">
      <Breadcrumb />
      <div class="d-flex justify-content-end form-group mt-2">
        <div class="col-md-3">
          <input
            type="text"
            class="form-control"
            placeholder="Search names"
            v-model="searchName"
          />
        </div>
      </div>
      <table class="table table-bordered">
        <thead>
          <th v-for="head in headers" :key="head">{{ head }}</th>
        </thead>
        <tbody>
          <tr v-for="user in filteredUsers" :key="user.id">
            <td>{{ user.name }}</td>
            <td>{{ user.role }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.status_value }}</td>
            <td>
              <button
                @click.prevent="editProfile(user)"
                class="btn btn-primary shadow btn-xs sharp mr-1"
              >
                <i class="bi bi-pencil-fill"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div
        class="modal fade show"
        id="exampleModalCenter"
        tabindex="-1"
        aria-labelledby="exampleModalCenterTitle"
        aria-modal="true"
        role="dialog"
        v-if="show"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title pt-3 pb-3">Account: {{ user.name }}</h5>
            </div>
            <div class="modal-body">
              <div class="mb-3 row">
                <label class="col-form-label mt-2">Role</label>
                <div class="col-sm">
                  <select
                    v-model="user.role_id"
                    class="form-control form-select form-select-md"
                    required
                  >
                    <option
                      v-for="role in roles"
                      :key="role.id"
                      :value="role.id"
                    >
                      {{ role.name }}
                    </option>
                  </select>
                </div>
              </div>
<!-- 
              <div class="mb-3 row">
                <label class="col-form-label">Email Address</label>
                <div class="col-sm">
                  <p class="mt-3">{{ user.email }}</p>
                </div>
              </div>

              <div class="mb-3 row">
                <label class="col-form-label mt-2">Name</label>
                <div class="col-sm">
                  <input
                    v-model="user.name"
                    type="text"
                    class="form-control"
                    required
                  />
                </div>
              </div>
-->

              <div class="mb-3 row">
                <label class="col-form-label mt-2">Password</label>
                <div class="col-sm">
                  <input
                    v-model="user.password"
                    type="text"
                    class="form-control"
                    required
                  />
                </div>
              </div>

              <div class="mb-3 row">
                <label class="col-form-label mt-2">Status</label>
                <div class="col-sm">
                  <select
                    v-model="user.status"
                    class="form-control form-select form-select-md"
                    required
                  >
                    <option
                      v-for="status in statuses"
                      :key="status.value"
                      :value="status.value"
                    >
                      {{ status.text }}
                    </option>
                  </select>
                </div>
              </div>

            </div>

            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                @click="toggleOpen"
              >
                Close
              </button>
              <button
                type="button"
                class="btn btn-primary"
                @click.prevent="profileUpdate"
              >
                Save changes
              </button>
            </div>
            
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Breadcrumb from "../../layouts/Breadcrumb.vue";

export default {
  components: {
    Breadcrumb,
  },
  data: () => ({
    searchName: "",
    show: false,
    headers: ["Name", "Role", "Email", "Status", "Actions"],
    statuses: [
      {
        value: 0, text: 'Inactive'
      },
      {
        value: 1, text: 'Active'
      }
    ],
  }),
  methods: {
    ...mapActions("user", ["fetchUsers", "assignUser", "updateProfile", "resetError"]),
    ...mapActions("role", ["fetchRoles"]),
    editProfile(user) {
      this.user.id = user.id;
      this.user.name = user.name;
      this.user.email = user.email;
      this.user.password = user.password;
      this.user.role_id = user.role_id;
      this.user.status = user.status;
      
      this.resetError();
      this.toggleOpen();
      this.assignUser(this.user);
    },
    toggleOpen() {
      this.show = !this.show;
    },
    profileUpdate() {
      this.updateProfile(this.user);
    },
  },
  computed: {
    ...mapGetters("user", ["users", "user", "errors"]),
    ...mapGetters("role", ["roles"]),
    filteredUsers() {
      let tempUsers = this.users;
      tempUsers = this.users.filter((user) => {
        return user.name.toLowerCase().includes(this.searchName.toLowerCase());
      });
      return tempUsers;
    },
  },
  mounted() {
    this.fetchUsers();
    this.fetchRoles();
  },
  watch: {
    'errors.error': function (val) {
      if (!val) {
        this.fetchUsers();
        this.toggleOpen();
      }
    }
  },
};
</script>

<style scoped>
.modal {
  position: absolute;
  background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

.show {
  display: block;
}
</style>