<template>
  <div>
    <div class="container-fluid">
      <div class="row justify-content-end form-group mt-2">
        <div class="col-auto col-md">
          <input
            type="text"
            class="form-control"
            placeholder="Search asset class names"
            v-model="searchName"
          />
        </div>
        <div class="col">
          <button
            type="button"
            id="add"
            class="btn btn-rounded btn-primary float-end"
            @click.prevent="toggleOpen"
          >
            <span class="btn-icon-left text-info">
              <i class="bi bi-plus"></i>
            </span>
            Create
          </button>
        </div>
      </div>
      <div class="row">
        <table class="table table-hover">
          <thead>
            <tr>
              <!-- <th>Name</th>
              <th colspan="4">Action</th> -->
              <th v-for="head in headers" :key="head">{{ head }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredAssetClasses.length == 0">
                <td :colspan="headers.length">
                    <div class="d-flex align-items-center">
                        <strong>Loading...</strong>
                        <div
                        class="spinner-border ms-auto"
                        role="status"
                        aria-hidden="true"
                        ></div>
                    </div>
                </td>
            </tr>
            <tr v-for="asset_class in filteredAssetClasses" :key="asset_class.id">
              <td>{{ asset_class.name }}</td>
              <td>{{ asset_types[asset_class.asset_type_id] }}</td>
              <td>{{ asset_class.sap_code }}</td>
              <td>
                <div class="d-flex">
                    <button
                      @click.prevent="update(asset_class)"
                      data-bs-name="asset_class.name"
                      type="button"
                      class="btn btn-primary shadow btn-xs sharp mr-1"
                    >
                      <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button
                      @click="setId(asset_class.id)"
                      type="button"
                      class="btn btn-danger shadow btn-xs sharp mr-1"
                    >
                      <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- Modal CREATE -->
        <div
          class="modal fade show"
          id="brandForm"
          data-bs-backdrop="static"
          tabindex="-1"
          aria-labelledby="brandForm"
          aria-hidden="true"
          v-if="show"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{ action }} class</h5>
                <button
                  @click.prevent="onClose"
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <form>
                  <!-- Types -->
                  <div class="mb-3">
                    <label>
                      Asset Class Type
                      <span class="text-danger">*</span>
                    </label>
                    <div>
                      <select
                        class="form-control fs-5"
                        :class="{ 'is-invalid': errors.asset_class_id }"
                        v-model="asset_class.asset_type_id"
                        required
                      >
                        <option
                          class="fs-5"
                          v-for="(asset_type, index) in asset_types"
                          :key="index"
                          :value="index"
                        >
                          {{ asset_type }}
                        </option>
                      </select>
                      <div v-if="errors.asset_type_id" class="invalid-feedback">
                        {{ errors.asset_type_id }}
                      </div>
                    </div>
                  </div>
                  <!-- name -->
                  <div class="mb-3">
                    <label for="class-name" class="col-form-label">Name:</label>
                    <input
                      id="name"
                      type="text"
                      v-model="asset_class.name"
                      class="form-control"
                      :class="{ 'is-invalid': errors.name }"
                      required
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                      {{ errors.name }}
                    </div>
                  </div>
                  <!-- sap code -->
                  <div class="mb-3">
                    <label for="class-name" class="col-form-label"
                      >Class Code:</label
                    >
                    <input
                      id="name"
                      type="text"
                      v-model="asset_class.sap_code"
                      class="form-control"
                      :class="{ 'is-invalid': errors.sap_code }"
                      required
                    />
                    <div v-if="errors.sap_code" class="invalid-feedback">
                      {{ errors.sap_code }}
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button
                  @click.prevent="onClose"
                  type="button"
                  class="btn btn-dark"
                  data-bs-dismiss="modal"
                >
                  Cancel
                </button>
                <button
                  @click.prevent="onSubmit"
                  type="button"
                  class="btn btn-primary"
                >
                  {{ action }}
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal DELETE -->
        <div
          class="modal fade show"
          tabindex="-1"
          id="delete"
          data-bs-backdrop="static"
          aria-labelledby="delete"
          aria-hidden="true"
          v-if="showDelete"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  @click.prevent="toggleDelete()"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to delete?</p>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-dark"
                  @click.prevent="toggleDelete()"
                >
                  Cancel
                </button>
                <button
                  @click.prevent="onDelete()"
                  type="button"
                  class="btn btn-danger"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Modal, Tooltip } from "bootstrap";
import { mapActions, mapGetters, mapState } from "vuex";
export default {
  components: {},
  data: () => ({
    searchName: "",
    asset_types: ["Software/Licenses", "Physical Assets"],
    headers: ['Asset Class', 'Asset Class Type', 'Asset Class Code', 'Action'],
    asset_class: {
      id: null,
      name: "",
      sap_code: null,
      asset_type_id: null,
    },
    action: "Create",
    show: false,
    showDelete: false,
    // errors: {}
  }),
  methods: {
    // ...mapActions("brands", ["fetchBrands", "createBrand", "updateBrand", "deleteBrand", "clearErrors", "resetBrand", "setBrand"]),
    ...mapActions("asset_class", [
      "fetchAssetClasses",
      "createAssetClass",
      "resetAssetClass",
      "clearErrors",
      "deleteAssetClass",
      "updateAssetClass",
    ]),
    async onSubmit() {
      this.clearErrors();

      if (this.action === "Create")
        await this.createAssetClass(this.asset_class);
      else await this.updateAssetClass(this.asset_class);

      if (Object.keys(this.errors).length) return;

      // modal.hide()
      this.fetchAssetClasses();
      this.toggleOpen();
      this.reset();
    },
    toggleOpen() {
      this.show = !this.show;
    },
    toggleDelete() {
      this.showDelete = !this.showDelete;
    },
    onClose() {
      this.toggleOpen();
      this.clearErrors();
      this.reset();
    },
    update(asset_class) {
      this.action = "Update";

      this.asset_class.name = asset_class.name;
      this.asset_class.id = asset_class.id;
      this.asset_class.sap_code = asset_class.sap_code;
      this.asset_class.asset_type_id = asset_class.asset_type_id;
      // modal.show();
      this.toggleOpen();
    },
    setId(id) {
      this.asset_class.id = id;
      this.toggleDelete();
    },
    async onDelete() {
      let modal = Modal.getInstance(document.getElementById("delete"));
      await this.deleteAssetClass(this.asset_class);
      if (!Object.keys(this.errors).length) this.toggleDelete();
    },
    reset() {
      // this.brand = this.getBrand
      this.resetAssetClass();
      this.asset_class = this.getAssetClass;
      this.clearErrors();
      this.action = "Create";
      console.log("clearing data", this.asset_class);
    },
  },
  computed: {
    // ...mapState({
    //     // brands: (state) => state.brands.brands,
    //     errors: (state) => state.classes.errors,
    // }),
    ...mapGetters("asset_class", ["asset_classes", "getAssetClass", "errors"]),
    filteredAssetClasses() {
      let list = this.asset_classes;
      list = this.asset_classes.filter((asset_class) => {
        return asset_class.name
          .toLowerCase()
          .includes(this.searchName.toLowerCase());
      });
      return list;
    },
  },
  created() {
    this.fetchAssetClasses();
  },
  watch: {},
};
</script>

<style scoped>
.modal {
  /* position: absolute; */
  background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}
/* .modal-content{
  margin-top:auto;
} */

.show {
  display: block;
  height: -webkit-fill-available;
}
</style>
