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
                          class="form-select fs-5"
                          v-model="asset.account_type"
                          required
                          disabled
                          @change="accountTypeChange"
                        >
                          <option
                            class="fs-5"
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
                      class="form-group col-md-6"
                    >
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
                        <div v-if="errors.asset_type_id" class="invalid-feedback">
                          {{ errors.asset_type_id }}
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Details -->
                  <div>
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
                        <div v-if="errors.asset_subclass_id" class="invalid-feedback">
                          {{ errors.asset_subclass_id }}
                        </div>
                      </div>
                    </div>
                    <!-- row 1 -->
                    <div class="asset_information">
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
                            <div class="form-group col-md-6">
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

                        <div>
                            <!-- row 1.2 -->
                            <div class="row">
                                <!-- Brand Models -->
                                <div class="form-group col-md">
                                    <label>
                                    Asset Description
                                    <span class="text-danger">*</span>
                                    </label>
                                    <p class="form-control fs-5 asset-description">{{ asset.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
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
                        
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="mb-3 row justify-content-md-end">
                            <div class="col-auto">
                                <button
                                :disabled="isLoading"
                                type="submit"
                                class="btn btn-danger"
                                @click.prevent="returnList"
                                >
                                Cancel
                                </button>
                            </div>
                        </div>
                        <!-- Submit -->
                        <div class="ml-1 mb-3 row justify-content-md-end">
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
                  </div>
                </form>
                <div
                    class="modal fade show d-flex justify-content-center"
                    tabindex="-1"
                    data-bs-backdrop="static"
                    aria-labelledby="loading"
                    aria-hidden="true"
                    v-if="isLoading"
                >
                    <div class="modal-dialog modal-dialog-centered">
                        <div>
                            <!-- <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"> -->
                                <!-- <span class="visually-hidden">Loading...</span> -->
                            <div class="spinner" role="status">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
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
      purchase_order_id: null,
      old_brand_model_id: null,
      old_asset_type_id: null,
      old_po_number: null,
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
      "updatePurchaseOrder",
    ]),
    ...mapActions("company", ["fetchCompanies"]),
    ...mapActions("physical_asset", ["fetchPhysicalAssets"]),
    ...mapActions("software_asset", ["createSoftwareAsset"]),
    ...mapActions("segments", ["fetchSegments"]),
    ...mapActions("inventory", ["setAssetType"]),
    async validate() {
        this.toogleLoading()
        console.log(`entries ${JSON.stringify(this.asset)}`);
        // return
        await this.updatePurchaseOrder(this.asset);

        if (!Object.keys(this.errors).length) {
            this.asset.asset_type_id == 0
            ? this.setAssetType(1)
            : this.setAssetType(2)

            this.$router.push({ path: "/asset-list" });
        };
        
        // console.log(`entries ${JSON.stringify(this.asset)}`);
        this.toogleLoading()
    },
    returnList(){
        this.$router.push({ path: "/asset-list" });
    },

    searchByType() {
      this.asset.asset_class_id = null
      this.asset.asset_subclass_id = null
      this.asset.brand_id = null
      this.asset.description = null
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
    async populateOnLoad()
    {
        let asset = this.asset_summary
        
        
        this.asset.asset_type_id = asset.asset_class.asset_type_id
        await this.fetchAssetClassesByType(this.asset.asset_type_id);
        this.asset.asset_class_id = asset.asset_class.id
        this.asset.asset_subclass_id = asset.asset_subclass.id
        this.asset.brand_id = asset.brand.id

        if(asset.latest_asset)
        {
            this.asset.segment_id = asset.latest_asset.segment_id
            this.asset.isDisposal = asset.latest_asset.disposal   
        }

        if(asset.latest_po)
        {
            this.asset.account_type = asset.latest_po.account_type.id
            this.asset.isPEZA = asset.latest_po.isPEZA
            this.asset.purchase_order_id = asset.latest_po.id
            this.asset.company_id = asset.latest_po.company.id
            this.asset.po_number = asset.latest_po.po_number
            this.asset.serial_number = asset.latest_po.serial_number
            this.asset.quantity = asset.latest_po.quantity
            this.asset.asset_value = asset.latest_po.asset_value
            this.asset.accounting_value = asset.latest_po.accounting_value
            this.asset.accumulated_depreciation = asset.latest_po.accumulated_depreciation
            this.asset.lifespan = asset.latest_po.lifespan
            this.asset.warranty_date = asset.latest_po.warranty_date
            this.asset.warranty_description = asset.latest_po.warranty_description
            this.asset.date_acquired = asset.latest_po.date_acquired
            this.asset.date_expired = asset.latest_po.expiration_date

            this.asset.old_po_number = asset.latest_po.po_number
        }

        this.asset.old_brand_model_id = asset.id
        this.asset.old_asset_type_id = asset.asset_class.asset_type_id
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
  async mounted() {
    if (Object.keys(this.asset_summary).length === 0) {
      this.$router.back();
      return
    }
    console.log('loading ...')
    this.toogleLoading()
    
    await this.populateOnLoad()

    await this.fetchCompanies();
    this.toogleLoading()
    console.log('loaded')
    
  },
  watch: {
    errors: function (val) {
      console.log(`errors ${JSON.stringify(val)}`);
      if (val == null) {
        this.$router.push({ path: "/home" });
      }
    },
    "asset.asset_type_id": function (val) {
        if(!this.isLoading)
          this.asset.asset_class_id = null;

      this.fetchSegments();
      this.resetAssetClassList();
    },
    "asset.asset_class_id": function (val) {
      if(!this.isLoading)
        this.asset.asset_subclass_id = null;
        
      this.resetAssetSubClassList();
      if (val) {
        this.fetchSelectedAssetSubClasses(val);
      }
    },
    "asset.asset_subclass_id": function (val) {
      if(!this.isLoading)
        this.asset.brand_id = null;

      this.resetBrandList();
      if (val) {
        this.fetchSelectedBrands(val);
      }
    },
    "asset.brand_id": async function (val) {
      if(!this.isLoading)
        this.asset.brand_model_id = null;

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

.form-control, .form-select {
  border: 1px solid #dededf;
  /* font-size: 1.125rem !important; */
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

.asset-description{
    height: 10em;
}
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

/* .spinner {

} */

.spinner > div {
  width: 18px;
  height: 18px;
  background-color: #76187e;

  border-radius: 100%;
  display: inline-block;
  -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
  animation: sk-bouncedelay 1.4s infinite ease-in-out both;
}

.spinner .bounce1 {
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}

.spinner .bounce2 {
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}

@-webkit-keyframes sk-bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0) }
  40% { -webkit-transform: scale(1.0) }
}

@keyframes sk-bouncedelay {
  0%, 80%, 100% { 
    -webkit-transform: scale(0);
    transform: scale(0);
  } 40% { 
    -webkit-transform: scale(1.0);
    transform: scale(1.0);
  }
}
</style>
