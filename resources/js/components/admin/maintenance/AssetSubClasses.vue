<template>
  <div>
    <div class="container-fluid">
      <div class="row justify-content-end form-group mt-2">
        <div class="col-auto col-md">
          <input
            type="text"
            class="form-control"
            placeholder="Search asset sub-class names"
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
            <tr v-if="filteredSubclasses.length == 0">
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
            <tr
              v-for="asset_subclass in filteredSubclasses"
              :key="asset_subclass.id"
            >
              <td>{{ asset_subclass.name }}</td>
              <td>
                {{ asset_subclass.asset_class.name }}
              </td>
              <td>
                <div class="d-flex">
                    <button
                      @click.prevent="update(asset_subclass)"
                      data-bs-name="asset_subclass.name"
                      type="button"
                      class="btn btn-primary shadow btn-xs sharp mr-1"
                    >
                      <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button
                      @click="setId(asset_subclass.id)"
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
                <h5 class="modal-title">{{ action }} Sub-Class</h5>
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
                    <label for="class-name" class="col-form-label">Name:</label>
                    <input
                      id="name"
                      type="text"
                      v-model="asset_subclass.name"
                      class="form-control"
                      :class="{ 'is-invalid': errors.name }"
                      required
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                      {{ errors.name }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label>
                      Asset Class
                      <span class="text-danger">*</span>
                    </label>
                    <div>
                      <model-list-select
                        :list="asset_classes"
                        v-model="asset_subclass.asset_class_id"
                        option-value="id"
                        option-text="name"
                        placeholder="Select Class"
                      />
                      <div
                        v-if="errors.asset_class_id"
                        class="invalid-feedback"
                      >
                        {{ errors.asset_class_id }}
                      </div>
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
    headers: ['Asset Sub-Class', 'Asset Class', 'Action'],
    asset_subclass: {
      id: null,
      name: "",
      asset_class_id: null,
      asset_class:{
          name: "",
          id: null
      }
    },
    action: "Create",
    show: false,
    showDelete: false,
    // errors: {}
  }),
  methods: {
    ...mapActions("asset_subclass", [
      "fetchAssetSubClasses",
      "createAssetSubClass",
      "resetAssetSubClass",
      "clearErrors",
      "deleteAssetSubClass",
      "updateAssetSubClass",
    ]),
    ...mapActions("asset_class", ["fetchAssetClasses"]),
    async onSubmit() {
        console.log('asset_subclass',this.asset_subclass);
        // return;
      this.clearErrors();
      if (this.action === "Create")
        await this.createAssetSubClass(this.asset_subclass);
      else await this.updateAssetSubClass(this.asset_subclass);

      if (Object.keys(this.errors).length) return;

      // modal.hide()
      this.toggleOpen();
      this.reset();
    },
    setAssetClass() {
      //TODO check if can optimized.
      // let asset_id = this.asset_subclass.asset_class.id;
      let asset_id = this.asset_subclass.asset_class_id;
      let assetclass = this.asset_classes.find(function (item) {
        return item.id == asset_id;
      });

      this.asset_subclass.asset_class_name = assetclass.name;
      this.asset_subclass.asset_class.name = assetclass.name;
      this.asset_subclass.asset_class_id = assetclass.id;
      this.asset_subclass.asset_class.id = assetclass.id;
      // this.asset_subclass.asset_class.id = assetclass.id
      // this.asset_subclass.asset_class.name = assetclass.name
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
    update(asset_subclass) {
      //TODO check if can optimized.
      this.action = "Update";
    //   this.asset_subclass = asset_subclass;
     
      var subclassName = asset_subclass.name;
      var className = asset_subclass.asset_class.name;
      this.asset_subclass.name = subclassName;
      this.asset_subclass.id = asset_subclass.id;

      this.asset_subclass.asset_class.id = asset_subclass.asset_class.id;
      this.asset_subclass.asset_class_id = asset_subclass.asset_class.id;

      this.asset_subclass.asset_class.name = className;
      this.asset_subclass.asset_class_name = asset_subclass.asset_class.name;

      // modal.show();
      this.toggleOpen();
    },
    setId(id) {
      this.asset_subclass.id = id;
      this.toggleDelete();
    },
    async onDelete() {
      let modal = Modal.getInstance(document.getElementById("delete"));
      await this.deleteAssetSubClass(this.asset_subclass);
      if (!Object.keys(this.errors).length) this.toggleDelete();
    },
    reset() {
      // this.brand = this.getBrand
      this.resetAssetSubClass();
    //   this.asset_subclass = this.getAssetSubClass;
      // console.log(this.asset_subclass);return
    //   this.clearErrors();
      this.action = "Create";
      console.log("clearing data", this.asset_subclass);
    },
  },
  computed: {
    // ...mapState({
    //     // brands: (state) => state.brands.brands,
    //     errors: (state) => state.classes.errors,
    // }),
    ...mapGetters("asset_class", ["asset_classes"]),
    ...mapGetters("asset_subclass", [
      "asset_subclasses",
      "getAssetSubClass",
      "errors",
    ]),
    filteredSubclasses() {
      let list = this.asset_subclasses;
      list = this.asset_subclasses.filter((asset_subclasses) => {
        return asset_subclasses.name
          .toLowerCase()
          .includes(this.searchName.toLowerCase());
      });
      return list;
    },
  },
  mounted() {
    this.fetchAssetClasses();
  },
  created() {
    this.fetchAssetSubClasses();
  },
  watch: {
      "asset_subclass.asset_class_id": function(val) {
          if(val)
          {
              let assetclass = this.asset_classes.find(function (item) {
                        return item.id == val;
              });
              this.asset_subclass.asset_class.name = assetclass.name;
              this.asset_subclass.asset_class.id = assetclass.id;
          }
      }
  },
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
