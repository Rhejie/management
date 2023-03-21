<template>
  <div>
    <div class="container-fluid">
      <div class="row justify-content-end form-group mt-2">
        <div class="col-auto col-md">
          <input
            type="text"
            class="form-control"
            placeholder="Search brand model names"
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
            <tr v-if="filteredModels.length == 0">
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
            
            <tr v-for="brand_model in filteredModels" :key="brand_model.id">
              <td>{{ brand_model.brand.name }}</td>
              <td>{{ brand_model.other_name }}</td>
              <td>
                {{ brand_model.name }}
              </td>
              <td>
                {{ brand_model.description }}
              </td>
              <td>
                <div class="d-flex">
                    <button
                      @click.prevent="update(brand_model)"
                      data-bs-name="brand_model.name"
                      type="button"
                      class="btn btn-primary shadow btn-xs sharp mr-1"
                    >
                      <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button
                      @click="setId(brand_model.id)"
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
                <h5 class="modal-title">{{ action }} Brand Model</h5>
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
                  <div class="form-group">
                    <label>
                      Brand
                      <span class="text-danger">*</span>
                    </label>
                    <div>
                      <model-list-select
                        :list="allBrands"
                        v-model="brand_model.brand_id"
                        option-value="id"
                        option-text="name"
                        placeholder="Select Brand"
                      />
                      <div v-if="errors.brand_id" class="invalid-feedback">
                        {{ errors.brand_id }}
                      </div>
                    </div>
                  </div>
                  <!-- other name -->
                  <div class="form-group">
                    <label for="class-name" class="col-form-label"
                      >Model:</label
                    >
                    <input
                      id="name"
                      type="text"
                      v-model="brand_model.other_name"
                      class="form-control"
                      :class="{ 'is-invalid': errors.name }"
                      required
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                      {{ errors.name }}
                    </div>
                  </div>
                  <!-- name -->
                  <div class="form-group">
                    <label for="class-name" class="col-form-label">Name:</label>
                    <input
                      id="name"
                      type="text"
                      v-model="brand_model.name"
                      class="form-control"
                      :class="{ 'is-invalid': errors.name }"
                      required
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                      {{ errors.name }}
                    </div>
                  </div>
                  <!-- description -->
                  <div class="form-group">
                    <label for="class-name" class="col-form-label"
                      >Description:</label
                    >
                    <textarea
                      v-model="brand_model.description"
                      class="form-control"
                      :class="{ 'is-invalid': errors.description }"
                      required
                      cols="30"
                      rows="5"
                    ></textarea>
                    <div v-if="errors.description" class="invalid-feedback">
                      {{ errors.description }}
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
    ModelListSelect
  },
  data: () => ({
    searchName: "",
    headers: ['Brand', 'Model', 'Name', 'Description', 'Action'],
    brand_model: {
      id: null,
      name: "",
      brand_id: null,
      other_name: null,
      description: "",
      brand: {
        id: null,
        name: "",
      },
    },
    action: "Create",
    show: false,
    showDelete: false,
    // errors: {}
  }),
  methods: {
    ...mapActions("brand_model", [
      "fetchBrandModels",
      "createBrandModel",
      "resetBrandModel",
      "clearErrors",
      "deleteBrandModel",
      "updateBrandModel",
    ]),
    ...mapActions("brands", ["fetchBrands"]),
    async onSubmit() {
      this.clearErrors();
      this.brand_model.brand = this.allBrands.find((item) => {
          return item.id == this.brand_model.brand_id
      })
      if (this.action === "Create")
        await this.createBrandModel(this.brand_model);
      else
        await this.updateBrandModel(this.brand_model).then(() => {
          this.fetchBrandModels();
        });

      if (Object.keys(this.errors).length) return;

      // modal.hide()
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
    update(brand_model) {
      console.log("selected brand model", brand_model);
      console.log("old brand model", this.brand_model);
      //TODO check if can optimized.
      this.action = "Update";
      // this.brand_model = brand_model;

      this.brand_model.name = brand_model.name;
      this.brand_model.id = brand_model.id;
      this.brand_model.brand.id = brand_model.brand.id;
      this.brand_model.brand_id = brand_model.brand.id;
    //   this.brand_model.brand_name = brand_model.brand.name;
      this.brand_model.other_name = brand_model.other_name;
      this.brand_model.description = brand_model.description;

      console.log("new brand model", this.brand_model);
      // this.brand_model.brand.name = brand_model.brand.name;
      // modal.show();
      this.toggleOpen();
    },
    setId(id) {
      this.brand_model.id = id;
      this.toggleDelete();
    },
    async onDelete() {
      let modal = Modal.getInstance(document.getElementById("delete"));
      await this.deleteBrandModel(this.brand_model);
      if (!Object.keys(this.errors).length) this.toggleDelete();
    },
    reset() {
      // this.brand = this.getBrand
      this.resetBrandModel();
      this.brand_model = this.getBrandModel;
      // console.log(this.brand_model);return
      this.clearErrors();
      this.action = "Create";
      console.log("clearing data", this.brand_model);
    },
  },
  computed: {
    // ...mapState({
    //     // brands: (state) => state.brands.brands,
    //     errors: (state) => state.classes.errors,
    // }),
    ...mapGetters("brands", ["allBrands"]),
    ...mapGetters("brand_model", ["brand_models", "getBrandModel", "errors"]),
    filteredModels() {
      let list = this.brand_models;
      list = this.brand_models.filter((brand_model) => {
        return brand_model.name
          .toLowerCase()
          .includes(this.searchName.toLowerCase());
      });
      return list;
    },
  },
  watch: {
  },
  mounted() {
    this.fetchBrands();
  },
  created() {
    this.fetchBrandModels();
  },
  watch: {},
};
</script>

<style scoped>
.modal {
  /* position: absolute; */
  background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}
.modal-content{
  margin-top:auto;
}

.show {
  display: block;
  height: -webkit-fill-available;
}
</style>
