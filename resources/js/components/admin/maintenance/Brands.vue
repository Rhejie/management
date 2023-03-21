<template>
  <div>
    <div class="container-fluid">
      <div class="row justify-content-end form-group mt-2">
        <div class="col-auto col-md">
          <input
            type="text"
            class="form-control"
            placeholder="Search brand names"
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
              <th v-for="head in headers" :key="head">{{ head }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredBrands.length == 0">
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
            <tr v-for="brand in filteredBrands" :key="brand.id">
              <td>{{ brand.name }}</td>
              <td>{{ brand.asset_class.name }}</td>
              <td>{{ brand.asset_subclass.name }}</td>
              <td>
                <div class="d-flex">
                    <button
                      @click.prevent="update(brand)"
                      type="button"
                      class="btn btn-primary shadow btn-xs sharp mr-1"
                    >
                      <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button
                      @click="setId(brand.id)"
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
                <h5 class="modal-title">{{ action }} Brand</h5>
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
                  <!-- assets classes -->
                  <div class="mb-3">
                    <label>
                      Asset Class
                      <span class="text-danger">*</span>
                    </label>
                    <div>
                      <model-list-select
                        :list="asset_classes"
                        v-model="brand.asset_class_id"
                        option-value="id"
                        option-text="name"
                        placeholder="Select Class"
                        autocomplete="off"
                      />
                      <div
                        v-if="errors.asset_class_id"
                        class="invalid-feedback"
                      >
                        {{ errors.asset_class_id }}
                      </div>
                    </div>
                  </div>
                  <!-- asset sub classes -->
                  <div class="mb-3">
                    <label>
                      Asset SubClass
                      <span class="text-danger">*</span>
                    </label>
                    <div>
                      <model-list-select
                        :list="filteredSubClasses"
                        v-model="brand.asset_subclass_id"
                        option-value="id"
                        option-text="name"
                        placeholder="Select Class"
                      />
                      <div
                        v-if="errors.asset_subclass_id"
                        class="invalid-feedback"
                      >
                        {{ errors.asset_subclass_id }}
                      </div>
                    </div>
                  </div>
                  <!-- name -->
                  <div class="mb-3">
                    <label for="brand-name" class="col-form-label">Name:</label>
                    <input
                      id="name"
                      type="text"
                      v-model="brand.name"
                      class="form-control"
                      :class="{ 'is-invalid': errors.name }"
                      required
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                      {{ errors.name }}
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
import { ModelListSelect } from "vue-search-select";
export default {
  components: {
    ModelListSelect,
  },
  data: () => ({
    searchName: "",
    headers: ['Brand','Asset Class','Asset Sub-Class','Action'],
    brand: {
      id: null,
      name: "",
      asset_class_id: null,
      asset_subclass_id: null,
      // company_name: "",
    },
    action: "Create",
    show: false,
    showDelete: false,
    // errors: {}
  }),
  methods: {
    ...mapActions("brands", [
      "fetchBrands",
      "createBrand",
      "updateBrand",
      "deleteBrand",
      "clearErrors",
      "resetBrand",
      "setBrand",
    ]),
    ...mapActions("asset_class", ["fetchAssetClasses"]),
    onSubmit() {
      this.clearErrors();
      if (this.action === "Create") {
        this.createBrand(this.brand).then(() => {
          if (Object.keys(this.errors).length) return;
          this.fetchBrands();
          this.onClose();
        });
      } else {
        this.updateBrand(this.brand).then(() => {
          if (Object.keys(this.errors).length) return;
          this.fetchBrands();
          this.onClose();
        });
      }
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
    update(brand) {
      this.action = "Update";
      // this.setBrand(brand)
      // let container = document.getElementById("brandForm");
      // let modal = new Modal(container);

      this.brand.name = brand.name;
      // this.brand.company_name = brand.company_name
      this.brand.id = brand.id;
      this.brand.asset_class_id = brand.asset_class.id;
      this.brand.asset_subclass_id = brand.asset_subclass_id;
      // modal.show();
      this.toggleOpen();
    },
    setId(id) {
      this.brand.id = id;
      this.toggleDelete();
    },
    async onDelete() {
      let modal = Modal.getInstance(document.getElementById("delete"));
      await this.deleteBrand(this.brand);
      if (!Object.keys(this.errors).length) this.toggleDelete();
    },
    reset() {
      // this.brand = this.getBrand
      // this.resetBrand();
      this.brand.id = null;
      this.brand.name = "";
      this.brand.asset_class_id = null;
      this.brand.asset_subclass_id = null;
      this.clearErrors();
      this.action = "Create";
      console.log("clearing data", this.brand);
    },
  },
  computed: {
    ...mapState({
      // brands: (state) => state.brands.brands,
      errors: (state) => state.brands.errors,
    }),
    ...mapGetters("brands", ["getErrors", "getBrand", "allBrands"]),
    ...mapGetters("asset_class", ["asset_classes", "getAssetClass"]),
    filteredSubClasses() {
      try {
        let asset_id = this.brand.asset_class_id;
        let assetclass = this.asset_classes.find((item) => {
          return item.id == asset_id;
        });

        return assetclass.sub_classes;
      } catch (error) {
        return [];
      }
    },
    filteredBrands() {
      let list = this.allBrands;
      list = this.allBrands.filter((brand) => {
        return brand.name
          .toLowerCase()
          .includes(this.searchName.toLowerCase());
      });
      return list;
    },
  },
  created() {
    this.fetchAssetClasses();
    this.fetchBrands();
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
