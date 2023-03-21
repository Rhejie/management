<template>
  <div class="pt-5">
    <div class="container-fluid">
      <Breadcrumb />
      <!-- row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Update Asset</h4>
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
                        <select
                          class="form-select fs-3"
                          v-model="asset.account_type"
                          required
                          @change="accountTypeChange"
                        >
                          <option
                            class="fs-4"
                            v-for="account_type in account_types"
                            :key="account_type.value"
                            :value="account_type.value"
                          >
                            {{ account_type.name }}
                          </option>
                        </select>
                        <div v-if="errors.account_type" class="invalid-feedback">
                          {{ errors.account_type }}
                        </div>
                      </div>
                    </div>
                    <!-- Asset Type -->
                    <div
                      v-if="asset.account_type != null"
                      class="form-group col-md-6"
                    >
                      <label>
                        Asset Type
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-select fs-3"
                          v-model="asset.asset_type_id"
                          required
                          @change="searchByType"
                        >
                          <option
                            class="fs-4"
                            v-for="asset_type in asset_types"
                            :key="asset_type.id"
                            :value="asset_type.id"
                          >
                            {{ asset_type.name }}
                          </option>
                        </select>
                        <div v-if="errors.asset_type_id" class="invalid-feedback">
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
                      <div v-if="asset.asset_class_id != null" class="form-group col-md-6">
                        <label>
                          Asset Subclass
                          <span class="text-danger">*</span>
                        </label>
                        <model-list-select
                          :list="asset_subclasses"
                          v-model="asset.asset_subclass_id"
                          option-value="id"
                          option-text="name"
                          placeholder="Select Asset Subclass"
                        >
                        </model-list-select>
                        <div v-if="errors.asset_subclass_id" class="invalid-feedback">
                          {{ errors.asset_subclass_id }}
                        </div>
                      </div>
                    </div>
                    <!-- row 1 -->
                    <div v-if="asset.asset_subclass_id != null" class="asset_information">
                        <hr />
                        <h3 class="mt-4 mb-3">Asset Information</h3>
                        <div class="row">
                            <!-- Brands -->
                            <div class="form-group col-md-6">
                                <label>Brands <span class="text-danger">*</span></label>
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
                            <div v-if="asset.brand_id != null" class="form-group col-md-6">
                                <label>Asset Name <span class="text-danger">*</span></label>
                                <model-list-select
                                    :list="brand_models"
                                    v-model="asset.brand_model_id"
                                    option-value="id"
                                    option-text="name"
                                    placeholder="Select Brand Name"
                                >
                                </model-list-select>
                                <div v-if="errors.brand_model_id" class="invalid-feedback">
                                    {{ errors.brand_model_id }}
                                </div>
                            </div>
                        </div>

                        <div v-if="asset.brand_model_id != null">
                            <!-- row 1.2 -->
                            <div class="row">
                                <!-- Brand Models -->
                                <div class="form-group col-md">
                                    <label>
                                    Asset Description
                                    <span class="text-danger">*</span>
                                    </label>
                                    <!-- <p class="form-control fs-4">{{ asset.description }}</p> -->
                                    <textarea
                                        v-model="asset.description"
                                        class="form-control fs-4"
                                        cols="30"
                                        rows="5"
                                    ></textarea>
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
                                            valueType="format"
                                            :input-class="'form-control fs-4'"
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
                                        valueType="format"
                                        :input-class="'form-control fs-4'"
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
                                        class="form-control fs-4"
                                        required
                                    >
                                        <option
                                        class="fs-4"
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
                                        class="form-control fs-4"
                                        v-model="asset.isDisposal"
                                    >
                                        <option
                                        class="fs-4"
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
                                        class="form-control fs-4"
                                        id="inventory-ispeza"
                                        name="inventory-ispeza"
                                        v-model="asset.isPEZA"
                                    >
                                        <option
                                        :class="{
                                            'is-invalid': errors.isPEZA,
                                        }"
                                        class="fs-4"
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
                        </div>
                    </div>

                    <div v-if="asset.brand_model_id != null">
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
                                class="form-control fs-4"
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
                                class="form-control fs-4"
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
                                class="datepicker-default form-control fs-4"
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
                                class="form-control fs-4"
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
                        <!-- ACCOUNTING VALUE -->
                        <div v-if="asset.account_type == 0" class="form-group col-md">
                            <label>
                            Accounting Value
                            <span class="text-danger">*</span>
                            </label>
                            <div>
                            <input
                                :class="{
                                'is-invalid': errors.accounting_value,
                                }"
                                type="number"
                                min="0"
                                onkeyup="if(this.value<0){this.value= this.value * -1}"
                                class="form-control fs-4"
                                v-model="asset.accounting_value"
                            />
                            <div
                                v-if="errors.accounting_value"
                                class="invalid-feedback"
                            >
                                {{ errors.accounting_value }}
                            </div>
                            </div>
                        </div>
                        <!-- Accumulated depreciation -->
                        <div v-if="asset.account_type == 0" class="form-group col-md">
                            <label>
                            Accumulated depreciation
                            <span class="text-danger">*</span>
                            </label>
                            <div>
                            <input
                                :class="{
                                'is-invalid': errors.accumulated_depreciation,
                                }"
                                type="number"
                                min="0"
                                onkeyup="if(this.value<0){this.value= this.value * -1}"
                                class="form-control fs-4"
                                v-model="asset.accumulated_depreciation"
                            />
                            <div
                                v-if="errors.accumulated_depreciation"
                                class="invalid-feedback"
                            >
                                {{ errors.accumulated_depreciation }}
                            </div>
                            </div>
                        </div>

                        <!-- lifespan -->
                        <div class="form-group col-md">
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
                                class="datepicker-default form-control fs-4"
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
                                valueType="format"
                                :input-class="'form-control fs-4'"
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
                                class="form-control fs-4"
                                cols="30"
                                rows="5"
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
                    </div>
                    <!-- Submit -->
                    <div v-if="asset.brand_model_id != null" class="mb-3 row justify-content-md-end">
                      <div class="col-auto">
                        <button
                          :disabled="isLoading"
                          type="submit"
                          class="btn btn-primary"
                          @click.prevent="validate"
                        >
                          Update
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
                <div
                    class="modal fade show"
                    tabindex="-1"
                    data-bs-backdrop="static"
                    aria-labelledby="loading"
                    aria-hidden="true"
                    v-if="isLoading"
                >
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
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
import { Modal, Tooltip } from "bootstrap";

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
    account_types: [
      {
        value: 0,
        name: "CAPEX",
      },
      {
        value: 1,
        name: "OPEX",
      },
    ],
    peza_options: [
      {
        value: 0,
        name: "FALSE",
      },
      {
        value: 1,
        name: "TRUE",
      },
    ],
    asset: {
      account_type: null,
      asset_type_id: null,
      asset_class_id: null,
      asset_subclass_id: null,
      brand_id: null,
      brand_model_id: null,
      description: null,
      segment_id: null,
      isDisposal: 0,
      asset_value: null,
      accounting_value: null,
      accumulated_depreciation: null,
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
    isLoading: true,
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
    ]),
    ...mapActions("company", ["fetchCompanies"]),
    ...mapActions("physical_asset", ["fetchPhysicalAssets"]),
    ...mapActions("software_asset", ["createSoftwareAsset"]),
    ...mapActions("segments", ["fetchSegments"]),

    async validate() {

    //   if(this.asset.asset_type_id == 2)
    //     await this.updateSoftwareAsset(this.asset);
    
    //   if(Object.keys(this.errors).length == 0)
    //     this.$router.push({ path: "/software-licenses" });
      this.toogleLoading()
      console.log(`entries ${JSON.stringify(this.asset)}`);
      this.toogleLoading()
    },

    searchByType() {
      this.fetchAssetClassesByType(this.asset.asset_type_id);
    },
    accountTypeChange(){
      this.asset.accounting_value = null;
      this.asset.accumulated_depreciation = null;
    },
    toogleLoading()
    {
        this.isLoading = !this.isLoading;
    },
    populateOnLoad()
    {
        // console.log(this.asset_summary);
        // return
        let asset = this.asset_summary
        
        this.asset.account_type = asset.latest_po.account_type.id
        this.asset.asset_type_id = asset.asset_class.asset_type_id
        this.fetchAssetClassesByType(this.asset.asset_type_id);
        this.asset.asset_class_id = asset.asset_class.id
        this.asset.asset_subclass_id = asset.asset_subclass.id
        this.asset.brand_id = asset.brand.id
        this.asset.date_acquired = asset.latest_po.date_acquired
        this.asset.date_expired = asset.latest_po.expiration_date
        this.asset.segment_id = asset.latest_asset.segment_id
        this.asset.isDisposal = asset.latest_asset.disposal
        this.asset.isPEZA = asset.latest_po.isPEZA
        // this.asset.company_id = asset.la
        this.asset.po_number = asset.latest_po.po_number
        this.asset.serial_number = asset.latest_po.serial_number
        this.asset.quantity = asset.latest_po.quantity
        this.asset.asset_value = asset.latest_po.asset_value
        this.asset.accounting_value = asset.latest_po.accounting_value
        this.asset.accumulated_depreciation = asset.latest_po.accumulated_depreciation
        this.asset.lifespan = asset.latest_po.lifespan
        this.asset.warranty_date = asset.latest_po.warranty_date
        this.asset.warranty_description = asset.latest_po.warranty_description
        this.toogleLoading()
    },
  },
  computed: {
    ...mapGetters("asset_summary", ["asset_summary"]),
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
    // this.fetchAssetClasses();
    // this.fetchBrands();
    // this.fetchCostCenters();
    // this.fetchPurchaseOrders();
    // this.fetchCompanies();
    // this.fetchPhysicalAssets();
    // this.asset = this.software_asset;
    
    if (Object.keys(this.asset_summary).length === 0) {
      this.$router.back();
      return
    }
    // this.toogleLoading()
    this.populateOnLoad()

    // this.fetchAssetClassesByType(this.asset.asset_type_id);
    
    //this.asset_summary.asset_class.asset_type_id
    // this.fetchAssetSubClasses(this.asset.asset_class_id);
    // this.sub_classes = assetclass.sub_classes;
  },
  watch: {
    errors: function (val) {
      console.log(`errors ${JSON.stringify(val)}`);
      if (val == null) {
        this.$router.push({ path: "/home" });
      }
    },
    "asset.asset_type_id": function (val) {
    //   this.asset.asset_class_id = null;
      this.fetchSegments();
      this.resetAssetClassList();
    },
    "asset.asset_class_id": function (val) {
    //   this.asset.asset_subclass_id = null;
      this.resetAssetSubClassList();
      if (val) {
        this.fetchSelectedAssetSubClasses(val);
      }
    },
    "asset.asset_subclass_id": function (val) {
    //   this.asset.brand_id = null;
      this.resetBrandList();
      if (val) {
        this.fetchSelectedBrands(val);
      }
    },
    "asset.brand_id": async function (val) {
    //   this.asset.brand_model_id = null;
      this.resetBrandModelList();
      if (val) {
        await this.fetchSelectedBrandModels(val);
        this.asset.brand_model_id = this.asset_summary.id
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

.invalid-feedback{
  display: block;
}
</style>
