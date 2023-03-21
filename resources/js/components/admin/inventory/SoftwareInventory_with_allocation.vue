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
                <form class="form-validate" action="#" method="post">
                  <div class="form-row">
                    <!-- Physical/License -->
                    <div class="form-group col-md-6">
                      <label>
                        Asset Type
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-control fs-4"
                          v-model="asset.asset_type_id"
                          required
                        >
                          <option
                            class="fs-4"
                            v-for="type in asset_types"
                            :key="type.id"
                            :value="type.id"
                          >
                            {{ type.name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- CAPEX/OPEX -->
                    <div class="form-group col-md-6">
                      <label>
                        Account Type
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-control fs-4"
                          v-model="asset.isOPEX"
                          required
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
                      </div>
                    </div>

                    <!-- Asset Class -->
                    <div class="form-group col-md-6">
                      <label>
                        Classification
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-control fs-4"
                          v-model="asset.asset_class_id"
                          @change="searchSubclasses"
                          required
                        >
                          <option
                            class="fs-4"
                            v-for="asset_class in asset_classes"
                            :key="asset_class.id"
                            :value="asset_class.id"
                          >
                            {{ asset_class.name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- Asset Sub class -->
                    <div class="form-group col-md-6">
                      <label>
                        Sub Class
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          v-model="asset.asset_subclass_id"
                          class="form-control fs-4"
                          required
                        >
                          <option
                            class="fs-4"
                            v-for="sub in sub_classes"
                            :key="sub.id"
                            :value="sub.id"
                          >
                            {{ sub.name }} {{ sub.extension }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- Brand -->
                    <div class="form-group col-md-6">
                      <label>
                        Model
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          v-model="asset.brand_id"
                          class="form-control fs-4"
                          required
                          @change="getCompanyName"
                        >
                          <option
                            class="fs-4"
                            v-for="brand in allBrands"
                            :key="brand.id"
                            :value="brand.id"
                          >
                            {{ brand.name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label>
                        Brand
                        <span class="text-danger">*</span>
                      </label>
                      <div class="mt-2">
                        <p class="fs-4">{{ company_name }}</p>
                      </div>
                    </div>

                    <!-- Asset Name -->
                    <div class="form-group col-md-6">
                      <label>
                        Name
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          v-model="asset.name"
                          type="text"
                          class="form-control fs-4"
                        />
                      </div>
                    </div>

                    <!-- Status? -->
                    <div class="form-group col-md-6">
                      <label>
                        Status
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          v-model="asset.status"
                          class="form-control fs-4"
                          required
                        >
                          <option
                            class="fs-4"
                            v-for="status in statuses"
                            :key="status"
                            :value="status"
                          >
                            {{ status }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group col-md-12">
                      <label>
                        Description
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <textarea
                          class="form-control fs-4"
                          v-model="asset.description"
                          rows="5"
                        ></textarea>
                      </div>
                    </div>

                    <!-- Date Acquired -->
                    <div class="form-group col-md-6">
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
                      </div>
                    </div>

                    <!-- Date Expired -->
                    <div class="form-group col-md-6">
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
                      </div>
                    </div>

                    <!-- PO -->
                    <div class="form-group col-md-6">
                      <label>
                        PO number
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          v-model="asset.po_number_id"
                          class="form-control fs-4"
                          required
                        >
                          <option
                            class="fs-4"
                            v-for="purchase_order in purchase_orders"
                            :key="purchase_order.id"
                            :value="purchase_order.id"
                          >
                            {{ purchase_order.po_number }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- Availability -->
                    <div class="form-group col-md-6">
                      <label>
                        Availability
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="text"
                          class="form-control fs-4"
                          v-model="asset.availability"
                        />
                      </div>
                    </div>

                    <!-- SAP CODE -->
                    <div class="form-group col-md-6">
                      <label>
                        Asset number / SAP code
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="text"
                          class="form-control fs-4"
                          v-model="asset.sap_code"
                        />
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
                      </div>
                    </div>

                    <!-- IsPEZA -->
                    <div class="form-group col-md-6">
                      <label>
                        is PEZA
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-control fs-4"
                          id="inventory-ispeza"
                          name="inventory-ispeza"
                        >
                          <option
                            class="fs-4"
                            v-for="option in peza_options"
                            :key="option.value"
                            :value="option.value"
                          >
                            {{ option.name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- Segment type -->
                    <div class="form-group col-md-6">
                      <label>
                        Segment type
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="text"
                          class="form-control fs-4"
                          v-model="asset.segment"
                        />
                      </div>
                    </div>

                    <!-- WARRANTY DATE -->
                    <div class="form-group col-md-6">
                      <label>
                        Warranty date
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <date-picker
                          v-model="asset.date_warranty"
                          valueType="format"
                          :input-class="'form-control fs-4'"
                        ></date-picker>
                      </div>
                    </div>

                    <!-- WARRANTY DESCRIPTION -->
                    <div class="form-group col-md-6">
                      <label>
                        Warranty description
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="text"
                          class="datepicker-default form-control fs-4"
                          v-model="asset.warranty_description"
                        />
                      </div>
                    </div>

                    <!-- COST CENTER -->
                    <div class="form-group col-md-6">
                      <label>
                        Asset Cost Center
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-control fs-4"
                          v-model="asset.cost_center_id"
                        >
                          <option
                            class="fs-4"
                            v-for="cost_center in cost_centers"
                            :key="cost_center.id"
                            :value="cost_center.id"
                          >
                            {{ cost_center.name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- DISPOSAL -->
                    <div class="form-group col-md-6">
                      <label>
                        Asset Cost Center
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-control fs-4"
                          v-model="asset.disposal"
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
                      </div>
                    </div>

                    <!-- ASSET VALUE -->
                    <div class="form-group col-md-6">
                      <label>
                        Asset Value
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="number"
                          class="form-control fs-4"
                          v-model="asset.asset_value"
                        />
                      </div>
                    </div>

                    <!-- ACCOUNTING VALUE -->
                    <div class="form-group col-md-6">
                      <label>
                        Accounting Value
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="number"
                          class="form-control fs-4"
                          v-model="asset.accounting_value"
                        />
                      </div>
                    </div>

                    <!-- Accumulated depreciation -->
                    <div class="form-group col-md-6">
                      <label>
                        Accumulated depreciation
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="text"
                          class="datepicker-default form-control fs-4"
                          v-model="asset.accumulated_depreciation"
                        />
                      </div>
                    </div>

                    <!-- lifespan -->
                    <div class="form-group col-md-6">
                      <label>
                        Lifespan
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="number"
                          class="datepicker-default form-control fs-4"
                          v-model="asset.lifespan"
                        />
                      </div>
                    </div>

                    <!-- end of form -->
                  </div>

                  <!-- Company allocation -->
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title">Company Allocations</div>

                      <div
                        class="row"
                        v-for="(
                          company_allocation, index
                        ) in asset.company_allocations"
                        :key="index"
                      >
                        <div class="col-md-5">
                          <label>
                            Company
                            <span class="text-danger">*</span>
                          </label>
                          <div>
                            <select
                              class="form-control fs-4"
                              v-model="company_allocation.company_id"
                            >
                              <option
                                class="fs-4"
                                v-for="company in companies"
                                :key="company.id"
                                :value="company.id"
                              >
                                {{ company.name }}
                              </option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-5">
                          <label>
                            Quantity Allocation
                            <span class="text-danger">*</span>
                          </label>
                          <div>
                            <input
                              type="number"
                              class="datepicker-default form-control fs-4"
                              v-model="company_allocation.quantity"
                            />
                          </div>
                        </div>

                        <div class="col-sm align-self-end">
                          <span
                            class="btn btn-warning btn-floating"
                            @click.prevent="addItem()"
                          >
                            <i class="bi bi-plus-circle"></i>
                          </span>
                          <span
                            v-if="asset.company_allocations.length > 1"
                            class="btn btn-danger btn-floating"
                            @click.prevent="removeItem(index)"
                          >
                            <i class="bi bi-trash"></i>
                          </span>
                        </div>

                        <!-- row end -->
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-12 ml-auto">
                      <button
                        type="submit"
                        class="btn btn-primary"
                        @click.prevent="validate"
                      >
                        Submit
                      </button>
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
import { mapActions, mapGetters } from "vuex";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import Breadcrumb from "../../layouts/Breadcrumb.vue";

export default {
  components: {
    DatePicker,
    Breadcrumb,
  },
  data: () => ({
    sub_classes: [],
    asset_types: [
      {
        id: 1,
        name: "Physical Asset",
      },
      {
        id: 2,
        name: "Software/License Asset",
      },
    ],
    account_types: [
      {
        value: true,
        name: "CAPEX",
      },
      {
        value: false,
        name: "OPEX",
      },
    ],
    peza_options: [
      {
        value: true,
        name: "TRUE",
      },
      {
        value: false,
        name: "FALSE",
      },
    ],
    statuses: ["Active", "Expired"],
    company_name: "",
    asset: {
      asset_type_id: null,
      asset_class_id: null,
      asset_subclass_id: null,
      isOPEX: false,
      brand_id: null,
      name: "",
      description: "",
      status: "",
      po_number_id: null,
      date_acquired: "",
      date_expired: "",
      availability: "",
      sap_code: null,
      serial_number: "",
      isPEZA: false,
      segment: "",
      date_warranty: "",
      warranty_description: "",
      cost_center_id: null,
      disposal: false,
      asset_value: null,
      accounting_value: null,

      accumulated_depreciation: null,
      lifespan: 0,

      company_allocations: [
        {
          company_id: null,
          quantity: null,
        },
      ],

      quantity: null,
      mother_asset_id: null,
      mother_asset_number: "",
    },
    isLoading: false,
    placeholder: ["my name is", "email@email.com"],
  }),
  methods: {
    ...mapActions("asset_class", ["fetchAssetClasses"]),
    ...mapActions("brands", ["fetchBrands"]),
    ...mapActions("cost_center", ["fetchCostCenters"]),
    ...mapActions("purchase_order", ["fetchPurchaseOrders"]),
    ...mapActions("company", ["fetchCompanies"]),

    validate() {
      console.log(`entries ${JSON.stringify(this.asset)}`);
    },

    addItem() {
      this.asset.company_allocations.push({
        company_id: null,
        quantity: null,
      });
    },
    removeItem(index) {
      this.asset.company_allocations.splice(index, 1);
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
  },
  computed: {
    ...mapGetters("asset_class", ["asset_classes", "asset_class"]),
    ...mapGetters("brands", ["allBrands"]),
    ...mapGetters("cost_center", ["cost_centers"]),
    ...mapGetters("purchase_order", ["purchase_orders"]),
    ...mapGetters("company", ["companies"]),
  },
  mounted() {
    this.fetchAssetClasses();
    this.fetchBrands();
    this.fetchCostCenters();
    this.fetchPurchaseOrders();
    this.fetchCompanies();
  },
  watch: {
    errors: function (val) {
      if (val == null) {
        this.$router.push({ path: "/home" });
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
</style>
