<template>
  <div class="pt-5">
    <div class="container-fluid">
      <Breadcrumb />
      <!-- row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Add Asset</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form class="form-validate">
                  <h3 class="mt-4 mb-3">Classifications</h3>
                  <!-- Account Type -->
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>
                        Account Type
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <p class="form-select fs-5">OPEX</p>
                      </div>
                    </div>
                    <!-- Asset Type -->
                    <div class="form-group col-md-6">
                      <label>
                        Asset Type
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-select fs-5"
                          v-model="asset.asset_type_id"
                          required
                          @change="searchByType"
                        >
                          <option
                            class="fs-5"
                            v-for="asset_type in asset_types"
                            :key="asset_type.id"
                            :value="asset_type.id"
                          >
                            {{ asset_type.name }}
                          </option>
                        </select>
                        <div
                          v-if="errors.asset_type_id"
                          class="invalid-feedback"
                        >
                          {{ errors.asset_type_id }}
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Details -->
                  <div v-if="asset.asset_type_id != null">
                    <div class="row">
                      <!-- Asset class -->
                      <div class="form-group col-md-6">
                        <label>
                          Asset Class
                          <span class="text-danger">*</span>
                        </label>
                        <model-list-select
                          :list="asset_classes"
                          v-model="asset.asset_class_id"
                          option-value="id"
                          option-text="name"
                          placeholder="Select Asset Class"
                        >
                        </model-list-select>
                      </div>
                      <!-- Subclass -->
                      <div class="form-group col-md-6">
                        <label>
                          Asset Sub-class
                          <span class="text-danger">*</span>
                        </label>
                        <model-list-select
                          :list="asset_subclasses"
                          v-model="asset.asset_subclass_id"
                          option-value="id"
                          option-text="name"
                          placeholder="Select Asset Sub-class"
                        >
                        </model-list-select>
                        <div
                          v-if="errors.asset_subclass_id"
                          class="invalid-feedback"
                        >
                          {{ errors.asset_subclass_id }}
                        </div>
                      </div>
                    </div>
                    <hr />
                    <!-- row 1 -->
                    <h3 class="mt-4 mb-3">Asset Information</h3>
                    <div class="row">
                      <!-- Brands -->
                      <div class="form-group col-md-6">
                        <label>
                          Brands
                          <span class="text-danger">*</span>
                        </label>
                        <model-list-select
                          :list="allBrands"
                          v-model="asset.brand_id"
                          option-value="id"
                          option-text="name"
                          placeholder="Select Brand Name"
                        >
                        </model-list-select>
                        <div v-if="errors.brand_id" class="invalid-feedback">
                          {{ errors.brand_id }}
                        </div>
                      </div>
                      <!-- Brand Models -->
                      <div class="form-group col-md-6">
                        <label>
                          Asset Name
                          <span class="text-danger">*</span>
                        </label>
                        <model-list-select
                          :list="brand_models"
                          v-model="asset.brand_model_id"
                          option-value="id"
                          option-text="name"
                          placeholder="Select Brand Name"
                        >
                        </model-list-select>
                        <div
                          v-if="errors.brand_model_id"
                          class="invalid-feedback"
                        >
                          {{ errors.brand_model_id }}
                        </div>
                      </div>
                    </div>
                    <!-- row 1.2 -->
                    <div class="row">
                      <!-- Brand Models -->
                      <div class="form-group col-md">
                        <label>
                          Asset Description
                          <span class="text-danger">*</span>
                        </label>
                        <p class="form-control fs-5">{{ asset.description }}</p>
                      </div>
                    </div>
                    <!-- row 1.3 -->
                    <div class="row">
                      <!-- date acquired -->
                      <div class="form-group col-md">
                        <label>
                          Date acquired
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <date-picker
                            v-model="asset.date_acquired"
                            value-type="YYYY-MM-DD"
                            :format="'YYYY-MMM-DD'"
                            :input-class="'form-control fs-5'"
                          ></date-picker>
                          <div
                            v-if="errors.date_acquired"
                            class="invalid-feedback"
                          >
                            {{ errors.date_acquired }}
                          </div>
                        </div>
                      </div>
                      <!-- Date Expired -->
                      <div class="form-group col-md">
                        <label>
                          Expiration date
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <date-picker
                            v-model="asset.date_expired"
                            value-type="YYYY-MM-DD"
                            :format="'YYYY-MMM-DD'"
                            :input-class="'form-control fs-5'"
                          ></date-picker>
                          <div
                            v-if="errors.date_expired"
                            class="invalid-feedback"
                          >
                            {{ errors.date_expired }}
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- row 1.4 -->
                    <div class="row">
                      <!-- Segment type -->
                      <div class="form-group col-md">
                        <label>
                          Segment type
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <select
                            v-model="asset.segment_id"
                            class="form-select fs-5"
                            required
                          >
                            <option
                              class="fs-5"
                              v-for="segment in segments"
                              :key="segment.id"
                              :value="segment.id"
                            >
                              {{ segment.name }}
                            </option>
                          </select>
                          <div
                            v-if="errors.segment_id"
                            class="invalid-feedback"
                          >
                            {{ errors.segment_id }}
                          </div>
                        </div>
                      </div>
                      <!-- DISPOSAL -->
                      <div class="form-group col-md">
                        <label>
                          For Disposal
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <select
                            class="form-select fs-5"
                            v-model="asset.isDisposal"
                          >
                            <option
                              class="fs-5"
                              v-for="peza_option in peza_options"
                              :key="peza_option.value"
                              :value="peza_option.value"
                            >
                              {{ peza_option.name }}
                            </option>
                          </select>
                          <div
                            v-if="errors.isDisposal"
                            class="invalid-feedback"
                          >
                            {{ errors.isDisposal }}
                          </div>
                        </div>
                      </div>

                      <!-- IsPEZA -->
                      <div class="form-group col-md">
                        <label>
                          is PEZA
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <select
                            class="form-select fs-5"
                            id="inventory-ispeza"
                            name="inventory-ispeza"
                            v-model="asset.isPEZA"
                          >
                            <option
                              :class="{
                                'is-invalid': errors.isPEZA,
                              }"
                              class="fs-5"
                              v-for="option in peza_options"
                              :key="option.value"
                              :value="option.value"
                            >
                              {{ option.name }}
                            </option>
                          </select>
                          <div v-if="errors.isPEZA" class="invalid-feedback">
                            {{ errors.isPEZA }}
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr />
                    <!-- row 2 -->
                    <h3 class="mt-4 mb-3">Accounting Information</h3>
                    <div class="form-row">
                      <!-- Subclass -->
                      <div class="form-group col-md">
                        <label>
                          Company
                          <span class="text-danger">*</span>
                        </label>
                        <model-list-select
                          :list="companies"
                          v-model="asset.company_id"
                          option-value="id"
                          option-text="name"
                          placeholder="Select Company"
                        >
                        </model-list-select>
                        <div v-if="errors.company_id" class="invalid-feedback">
                          {{ errors.company_id }}
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <!-- PO Number -->
                      <div class="form-group col-md-6">
                        <label>
                          PO Number
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <input
                            v-model="asset.po_number"
                            type="text"
                            class="form-control fs-5"
                          />
                          <div v-if="errors.po_number" class="invalid-feedback">
                            {{ errors.po_number }}
                          </div>
                        </div>
                      </div>
                      <!-- Serial Number -->
                      <div class="form-group col-md-6">
                        <label>
                          Serial number
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <input
                            type="text"
                            class="form-control fs-5"
                            v-model="asset.serial_number"
                          />
                          <div
                            v-if="errors.serial_number"
                            class="invalid-feedback"
                          >
                            {{ errors.serial_number }}
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- row 2.2 -->
                    <div class="row">
                      <!-- quantity -->
                      <!-- lifespan -->
                      <div class="form-group col-md">
                        <label>
                          Quantity
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <input
                            :class="{
                              'is-invalid': errors.quantity,
                            }"
                            type="number"
                            min="0"
                            onkeyup="if(this.value<0){this.value= this.value * -1}"
                            onkeypress="return !(event.charCode == 46)"
                            class="datepicker-default form-control fs-5"
                            v-model="asset.quantity"
                          />
                          <div v-if="errors.quantity" class="invalid-feedback">
                            {{ errors.quantity }}
                          </div>
                        </div>
                      </div>
                      <!-- ASSET VALUE -->
                      <div class="form-group col-md">
                        <label>
                          Asset Value
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <input
                            :class="{
                              'is-invalid': errors.asset_value,
                            }"
                            type="number"
                            min="0"
                            onkeyup="if(this.value<0){this.value= this.value * -1}"
                            class="form-control fs-5"
                            v-model="asset.asset_value"
                          />
                          <div
                            v-if="errors.asset_value"
                            class="invalid-feedback"
                          >
                            {{ errors.asset_value }}
                          </div>
                        </div>
                      </div>
                      <!-- lifespan -->
                      <div
                        v-if="asset.isDisposal == 0"
                        class="form-group col-md"
                      >
                        <label>
                          Lifespan in months
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <input
                            :class="{
                              'is-invalid': errors.lifespan,
                            }"
                            type="number"
                            min="0"
                            onkeyup="if(this.value<0){this.value= this.value * -1}"
                            class="datepicker-default form-control fs-5"
                            v-model="asset.lifespan"
                          />
                          <div v-if="errors.lifespan" class="invalid-feedback">
                            {{ errors.lifespan }}
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- row 2.3 -->
                    <div class="form-row">
                      <!-- WARRANTY DATE -->
                      <div class="form-group col-md">
                        <label>
                          Warranty date
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <date-picker
                            :class="{
                              'is-invalid': errors.warranty_date,
                            }"
                            v-model="asset.warranty_date"
                            value-type="YYYY-MM-DD"
                            :format="'YYYY-MMM-DD'"
                            :input-class="'form-control fs-5'"
                          ></date-picker>
                          <div
                            v-if="errors.warranty_date"
                            class="invalid-feedback"
                          >
                            {{ errors.warranty_date }}
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- row 2.4 -->
                    <div class="row">
                      <!-- WARRANTY DESCRIPTION -->
                      <div class="form-group col-md">
                        <label>
                          Warranty description
                          <span class="text-danger">*</span>
                        </label>
                        <div>
                          <textarea
                            v-model="asset.warranty_description"
                            class="form-control fs-5"
                            cols="30"
                            rows="10"
                          ></textarea>
                          <div
                            v-if="errors.warranty_description"
                            class="invalid-feedback"
                          >
                            {{ errors.warranty_description }}
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Submit -->

                    <div class="mb-3 row justify-content-md-end">
                      <div class="col-auto">
                        <button
                          :disabled="isLoading"
                          type="submit"
                          class="btn btn-primary"
                          @click.prevent="validate"
                        >
                          Submit
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from "vuex";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import Breadcrumb from "../../layouts/Breadcrumb.vue";
import { ModelListSelect } from "vue-search-select";

export default {
  components: {
    DatePicker,
    Breadcrumb,
    ModelListSelect,
  },
  data: () => ({
    sub_classes: [],
    asset_types: [
      {
        id: 0,
        name: "Software/License Asset",
      },
      {
        id: 1,
        name: "Physical Asset",
      },
    ],
    peza_options: [
      {
        value: 0,
        name: "NO",
      },
      {
        value: 1,
        name: "YES",
      },
    ],
    asset: {
      asset_type_id: null,
      asset_class_id: null,
      asset_subclass_id: null,
      brand_id: null,
      brand_model_id: null,
      description: null,
      segment_id: null,
      isDisposal: 0,
      asset_value: null,
      isPEZA: 0,
      lifespan: 0,
      company_id: null,
      po_number: null,
      serial_number: null,
      date_acquired: "",
      date_expired: "",
      quantity: null,
      warranty_date: "",
      warranty_description: "",
    },
    isLoading: false,
    placeholder: ["my name is", "email@email.com"],
  }),
  methods: {
    ...mapActions("asset_class", [
      "fetchAssetClassesByType",
      "resetAssetClassList",
    ]),
    ...mapActions("asset_subclass", [
      "fetchSelectedAssetSubClasses",
      "resetAssetSubClassList",
    ]),
    ...mapActions("brands", ["fetchSelectedBrands", "resetBrandList"]),
    ...mapActions("brand_model", [
      "fetchSelectedBrandModels",
      "resetBrandModelList",
    ]),
    ...mapActions("cost_center", ["fetchCostCenters"]),
    ...mapActions("purchase_order", [
      "fetchPurchaseOrders",
      "createPurchaseOrders",
      "resetError",
    ]),
    ...mapActions("company", ["fetchCompanies"]),
    ...mapActions("physical_asset", ["fetchPhysicalAssets"]),
    ...mapActions("software_asset", ["createSoftwareAsset"]),
    ...mapActions("segments", ["fetchSegments"]),
    ...mapActions("inventory", ["setAssetType"]),
    validate() {
      this.isLoading = true;
      this.createPurchaseOrders(this.asset).then(() => {
        console.log(`response ${JSON.stringify(this.errors)}`);
        if (!Object.keys(this.errors).length) {
          //   this.asset.asset_type_id == 0
          //   ? this.$router.push({ path: "/software-licenses" })
          //   : this.$router.push({ path: "/hardware-assets" });
          this.asset.asset_type_id == 0
            ? this.setAssetType(1)
            : this.setAssetType(2);

          this.$router.push({ path: "/asset-list" });
        }
      });

      console.log(`entries ${JSON.stringify(this.asset, null, "\t")}`);
      this.isLoading = false;
    },
    searchByType() {
      this.fetchAssetClassesByType(this.asset.asset_type_id);
    },

    searchSubclasses() {
      let asset_id = this.asset.asset_class_id;
      let assetclass = this.asset_classes.find(function (item) {
        return item.id == asset_id;
      });
      this.sub_classes = assetclass.sub_classes;
    },
    getCompanyName() {
      let brand_id = this.asset.brand_id;
      let brand = this.allBrands.find(function (item) {
        return item.id == brand_id;
      });
      this.company_name = brand.company_name;
    },
    searchBrandModels() {
      let brand_id = this.brand_id;
      let brands = this.allBrands;
    },
  },
  computed: {
    ...mapGetters("asset_class", ["asset_classes", "asset_class"]),
    ...mapGetters("asset_subclass", ["asset_subclasses"]),
    ...mapGetters("brands", ["allBrands"]),
    ...mapGetters("brand_model", ["brand_models"]),
    ...mapGetters("cost_center", ["cost_centers"]),
    ...mapGetters("purchase_order", ["purchase_orders", "errors"]),
    ...mapGetters("company", ["companies"]),
    ...mapGetters("physical_asset", ["physical_assets"]),
    ...mapGetters("segments", ["segments"]),
  },
  mounted() {
    // this.resetError()
  },
  watch: {
    errors: function (val) {
      console.log(`errors ${JSON.stringify(val)}`);
      if (val == null) {
        this.$router.push({ path: "/home" });
      }
    },
    "asset.asset_type_id": function (val) {
      this.asset.asset_class_id = null;
      this.fetchSegments();
      this.fetchCompanies();
      this.resetAssetClassList();
    },
    "asset.asset_class_id": function (val) {
      this.asset.asset_subclass_id = null;
      this.resetAssetSubClassList();
      if (val) {
        this.fetchSelectedAssetSubClasses(val);
      }
    },
    "asset.asset_subclass_id": function (val) {
      this.asset.brand_id = null;
      this.resetBrandList();
      if (val) {
        this.fetchSelectedBrands(val);
      }
    },
    "asset.brand_id": function (val) {
      this.asset.brand_model_id = null;
      this.resetBrandModelList();
      if (val) {
        this.fetchSelectedBrandModels(val);
      }
    },
    "asset.brand_model_id": function (val) {
      if (val) {
        let model = this.brand_models.find((item) => {
          return item.id == val;
        });
        this.asset.description = model.description;
      } else {
        this.asset.description = "";
      }
    },
    "asset.isDisposal": function (val) {
      if (val == 1) {
        this.asset.lifespan = 0;
      }
    },
  },
};
</script>

<style scoped>
.align-self-end {
  align-self: flex-end;
}

.btn-floating {
  font-size: 2rem;
  position: relative;
  z-index: 1;
  display: inline-block;
  padding: 0;
  margin: 10px;
  overflow: hidden;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 50%;
  -webkit-box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18),
    0 4px 15px 0 rgba(0, 0, 0, 0.15);
  box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18), 0 4px 15px 0 rgba(0, 0, 0, 0.15);
  -webkit-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
  width: 47px;
  height: 47px;
}

.form-control {
  border: 1px solid #dededf;
}

.mx-datepicker {
  border: 1px solid #dededf;
  width: 100%;
  border-radius: 0.4rem;
}

.is-invalid {
  border: 1px solid red;
  border-right: 1px solid red !important;
}

.invalid-feedback {
  display: block;
}

.form-control {
  height: calc(1.5em + 0.75rem + 2px);
}
</style>
