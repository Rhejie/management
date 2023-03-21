<template>
  <div class="pt-5 mb-5">
    <div class="container-fluid">
      <Breadcrumb />
      <div v-if="show">
        <roles-form :role="role" :title="title" @close="reload" />
      </div>

      <div v-else>
        <div class="d-flex form-group mt-2">
          <div class="me-auto col-md">
            <input
              type="text"
              class="form-control"
              placeholder="Search names"
              v-model="searchName"
            />
          </div>
          <div class="col-md-3">
            <button
              type="button"
              id="add"
              class="btn btn-rounded btn-primary float-end"
              @click.prevent="openCreate()"
            >
              <span class="btn-icon-left text-info">
                <i class="bi bi-plus"></i>
              </span>
              Create
            </button>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4 class="card-title">System Access List</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered align-top">
                <thead>
                  <th v-for="head in headers" :key="head">{{ head }}</th>
                </thead>
                <tbody>
                  <tr v-for="role in filteredRoles" :key="role.id">
                    <td class="align-top" width="20%">{{ role.name }}</td>
                    <td>
                      <div class="row">
                        <div
                          v-for="permission in role.permissions"
                          :key="permission.id"
                          class="col-md-5"
                        >
                          {{ permission.display }}
                        </div>
                      </div>
                    </td>
                    <td class="align-top">
                      <button
                        v-if="role.name != 'Admin'"
                        @click.prevent="selectRole(role)"
                        class="btn btn-primary shadow btn-xs sharp mr-1"
                      >
                        <i class="bi bi-pencil-fill"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- end of table -->
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Breadcrumb from "../../layouts/Breadcrumb.vue";
import RolesForm from "../maintenance/RolesForm.vue";

export default {
  components: {
    Breadcrumb,
    RolesForm,
  },
  data: () => ({
    searchName: "",
    show: false,
    title: "",
    headers: ["Name", "Permissions", "Actions"],
    role: {
      id: null,
      name: "",
      permissions: [],
    },
  }),
  methods: {
    ...mapActions("role", ["fetchRoles"]),
    toggleOpen() {
      this.show = !this.show;
    },
    reload() {
      this.toggleOpen();
      this.fetchRoles();
    },
    selectRole(role) {
      this.title = "Update Role";
      this.toggleOpen();
      this.role = {
        id: role.id,
        name: role.name,
        permissions: [],
      };

      role.permissions.forEach((permission) => {
        this.role.permissions.push(permission);
      });
    },
    openCreate() {
      this.title = "Create New Role";
      this.toggleOpen();
      this.role = {
        id: null,
        name: "",
        permissions: [],
      };
    },
    submitForm() {
      this.updateSelectedSite(this.site).then(() => {
        if (!this.errors.error) {
          this.toggleOpen();
        }
      });
    },
  },
  computed: {
    ...mapGetters("role", ["roles"]),
    filteredRoles() {
      let list = this.roles;
      list = this.roles.filter((item) => {
        return item.name.toLowerCase().includes(this.searchName.toLowerCase());
      });
      return list;
    },
  },
  mounted() {
    this.fetchRoles();
  },
};
</script>

<style scoped>
.modal {
  background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

.show {
  display: block;
}

.fade:not(.show) {
  opacity: 0;
}
</style>