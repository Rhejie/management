<template>
  <div>
    <div class="container-fluid">
      <!-- <Breadcrumb /> -->
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{ title }}</h4>
        </div>
        <div class="card-body">
          <div class="mb-3 row">
            <label class="col-sm-2 col-form-label mt-2">Name</label>
            <div class="col-sm">
              <input
                v-model="role.name"
                type="text"
                class="form-control"
                required
              />
              <div class="feedback" v-if="errors.error">
                <i v-for="error in errors.message.name" :key="error">{{
                  error
                }}</i>
              </div>
            </div>
          </div>

          <div class="row mt-5">
            <label class="col-sm-2 col-form-label mt-2">Permissions</label>
            <div
              class="col"
              v-for="(permission, index) in selected_permissions"
              :key="index"
            >
              <div class="card">
                <div class="card-header">
                  <div class="card-title">{{ permission.name }}</div>
                </div>
                <div class="card-body">
                  <div
                    v-for="category in permission.categories"
                    :key="category.id"
                    class="col-md"
                  >
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        v-model="category.is_checked"
                        :id="category.id"
                        @change="changedBox(category)"
                      />
                      <label class="form-check-label" :for="category.id">
                        {{ category.display }}
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-md-end">
            <div class="col-auto">
              <button
                type="submit"
                class="btn btn-primary"
                @click.prevent="validate"
              >
                Submit
              </button>
              <button
                type="button"
                id="add"
                class="btn btn-success"
                @click.prevent="close()"
              >
                Close
              </button>
            </div>
          </div>
          <!-- end card-body -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
// import Breadcrumb from "../../layouts/Breadcrumb.vue";
export default {
  props: {
    role: Object,
    title: String,
  },
  components: {
    // Breadcrumb,
  },
  data: () => ({
    modules: [],
  }),
  methods: {
    ...mapActions("permission", ["fetchPermissions"]),
    ...mapActions("role", ["createRole", "updateRole"]),
    changedBox(permission) {
      let index = this.role.permissions.findIndex((item) => {
        return item.id == permission.id;
      });
      if (index < 0) {
        this.role.permissions.push(permission);
      } else {
        this.role.permissions.splice(index, 1);
      }
      console.log(`list ${JSON.stringify(this.role.permissions)}`);
    },
    validate() {
      if (this.role.id == null) {
        this.createRole(this.role).then(() => {
          if (!this.errors.error) {
            this.close();
          }
        });
      } else {
        this.updateRole(this.role).then(() => {
          if (!this.errors.error) {
            this.close();
          }
        });
      }
    },
    close() {
      this.$emit("close", false);
    },
  },
  computed: {
    ...mapGetters("permission", ["permissions"]),
    ...mapGetters("role", ["errors"]),
    selected_permissions() {
      let list = [];
      let categories = [];
      let name = "";

      this.permissions.forEach((element, index) => {
        let permission = undefined;

        if (this.role.permission != []) {
          permission = this.role.permissions.find((item) => {
            return item.id == element.id;
          });
        }

        console.log(`${name} ${element.module}`);

        if (index == 0) {
          name = element.module;
        }

        if (name == element.module) {
          categories.push({
            id: element.id,
            name: element.name,
            display: element.display,
            is_checked: permission != undefined,
          });
        } else {
          list.push({
            name: name,
            categories: categories,
          });
          categories = [];
          name = element.module;
        }
      });

      list.push({
        name: name,
        categories: categories,
      });

      return list;
    },
  },
  created() {
    this.fetchPermissions();
  },
  watch: {},
};
</script>
