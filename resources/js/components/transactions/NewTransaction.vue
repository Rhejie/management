<template>
  <div class="pt-5">
    <div class="container-fluid">
      <Breadcrumb />
      <!-- row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Asset Requisition</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form class="form-validate">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-header">
                          <h4 class="card-title">Asset Requisition</h4>
                        </div>
                        <div class="card-body">
                          <div class="form-validation">
                            <form class="form-validate">
                              <div class="form-row mb-4">
                                <div class="col-md-4 col-lg-3">
                                  <label>User</label>
                                </div>
                                <div class="col-md-8 col-lg-9">
                                  <div class="form-group">
                                    <label for="transaction-assign-user-type"
                                      >Select an Asset User Type
                                      <span class="text-danger">*</span>
                                    </label>
                                    <div>
                                      <model-list-select
                                        :list="proponent_types"
                                        v-model="transaction.proponent_type_id"
                                        option-value="id"
                                        option-text="type"
                                        placeholder="Please Select"
                                      >
                                      </model-list-select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label
                                      >Select a specific User to assign asset
                                      <span class="text-danger">*</span>
                                    </label>
                                    <div class="mb-4">
                                      <div
                                        v-if="!transaction.proponent_id"
                                        class="row"
                                      >
                                        <div class="col">
                                          <input
                                            v-model="search"
                                            type="text"
                                            class="form-control fs-5"
                                          />
                                          <div v-if="search">
                                            <ul class="search list-group">
                                              <li
                                                class="list-group-item"
                                                v-for="searched in searchedList"
                                                :key="searched.id"
                                                @click="
                                                  setSelectedProponent(searched)
                                                "
                                              >
                                                {{ searched.name }}
                                              </li>
                                            </ul>
                                          </div>
                                        </div>
                                        <div v-if="search" class="col">
                                          <button
                                            @click.prevent="searchProponent"
                                            class="btn btn-primary btn-sm fs-5"
                                          >
                                            Search
                                          </button>
                                        </div>
                                      </div>
                                      <!-- selected -->
                                      <div v-else class="row">
                                        <div class="col">
                                          <p class="form-control fs-5">
                                            {{ selected_proponent.name }}
                                          </p>
                                        </div>
                                        <div v-if="search" class="col">
                                          <button
                                            @click.prevent="resetProponent"
                                            class="btn btn-primary btn-sm fs-5"
                                          >
                                            Reset
                                          </button>
                                        </div>
                                      </div>
                                    </div>

                                    <div
                                      v-if="transaction.proponent_id"
                                      class="form-group mb-4"
                                    >
                                      <div class="row">
                                        <div class="col-md-7">
                                          <selected-list
                                            :selected_proponent="
                                              selected_proponent
                                            "
                                          />
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <hr class="page-divider" />

                              <div class="form-row mb-4">
                                <div class="col-md-4 col-lg-3">
                                  <label class="text-uppercase font-weight-bold"
                                    >Asset to be assigned</label
                                  >
                                </div>
                                <div class="col-md-8 col-lg-9">
                                  <div class="form-group">
                                    <label for="transaction-assign-asset"
                                      >Select an Asset to be assigned
                                      <span class="text-danger">*</span>
                                    </label>
                                    <div class="mb-4">
                                      <div v-if="!selected_asset.id" class="row">
                                        <div class="col">
                                          <input
                                            v-model="search_asset"
                                            type="text"
                                            class="form-control fs-5"
                                          />
                                          <div v-if="search_asset">
                                            <ul class="search list-group">
                                              <li
                                                class="list-group-item"
                                                v-for="model in brand_models"
                                                :key="model.id"
                                                @click="setSelectedAsset(model)"
                                              >
                                                {{ model.name }}
                                              </li>
                                            </ul>
                                          </div>
                                        </div>
                                        <div v-if="search_asset" class="col">
                                          <button
                                            @click.prevent="searchAsset"
                                            class="btn btn-primary btn-sm fs-5"
                                          >
                                            Search
                                          </button>
                                        </div>
                                      </div>
                                      <!-- selected -->
                                      <div v-else class="row">
                                        <div class="col">
                                          <p class="form-control fs-5">
                                            {{ selected_asset.name }}
                                          </p>
                                        </div>
                                        <div v-if="search_asset" class="col">
                                          <button
                                            @click.prevent="resetAsset"
                                            class="btn btn-primary btn-sm fs-5"
                                          >
                                            Reset
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!--  -->
                                  <div class="form-group">
                                    <label for="transaction-assign-asset"
                                      >Select an P.O to be assigned
                                      <span class="text-danger">*</span>
                                    </label>
                                    <div class="mb-4">
                                      <model-list-select
                                        :list="selected_asset.purchase_orders"
                                        v-model="transaction.purchase_order_id"
                                        option-value="id"
                                        option-text="po_number"
                                        placeholder="Please Select"
                                      >
                                      </model-list-select>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <hr class="page-divider" />

                              <div class="form-group row">
                                <div class="col-md-12 ml-auto">
                                  <button type="submit" class="btn btn-primary">
                                    Save &amp; Submit
                                  </button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end of row -->
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
import Breadcrumb from "../layouts/Breadcrumb.vue";
import { ModelListSelect } from "vue-search-select";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import SelectedList from "./SelectedList.vue";

export default {
  components: {
    DatePicker,
    Breadcrumb,
    ModelListSelect,
    SelectedList,
  },
  data: () => ({
    search: null,
    search_name: "",
    search_asset: "",
    transaction: {
      proponent_type_id: null,
      asset_type_id: null,
      proponent_id: null,
      purchase_order_id: null
    },
    selected_proponent: {
      type: "",
      name: "",
      number: "",
      company: "",
      cost_center: "",
    },
    selected_asset: {
      id: null,
      name: "",
      purchase_orders: [],
    },
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
  }),
  methods: {
    ...mapActions("proponent", [
      "fetchProponentTypes",
      "employeeSearch",
      "campaignSearch",
      "resetCampaigns",
      "resetEmployees",
    ]),
    ...mapActions("site", ["siteSearch", "resetSites"]),
    ...mapActions("physical_asset", ["fetchPhysicalAssetInventory"]),
    ...mapActions("software_asset", ["fetchSoftwareInventory"]),
    ...mapActions("brand_model", ["brandModelSearchAll", "resetBrandModelList"]),
    changeAssetType() {
      this.transaction.asset_type_id == 0
        ? this.fetchSoftwareInventory()
        : this.fetchPhysicalAssetInventory();
    },
    searchProponent() {
      let data = {
        search_name: this.search,
      };
      switch (this.transaction.proponent_type_id) {
        case 1:
          this.employeeSearch(data);
          break;
        case 2:
          this.campaignSearch(data);
          break;
        case 3:
          this.siteSearch(data);
          break;
      }
    },
    searchAsset() {
      let data = {
        search_name: this.search_asset,
      };
      this.brandModelSearchAll(data);
    },
    resetProponent() {
      this.transaction.proponent_id = null;
      this.selected_proponent = {
        name: "",
        number: "",
        company: "",
        cost_center: "",
      };
      this.resetCampaigns();
      this.resetEmployees();
      this.resetSites();
    },
    resetAsset() {
      this.search_asset = "";
      this.selected_asset = {
        id: null,
        name: "",
        purchase_orders: [],
      };
      this.resetBrandModelList();
    },
    setSelectedProponent(proponent) {
      this.resetProponent();
      this.transaction.proponent_id = proponent.id;
      this.selected_proponent.name = proponent.name;
      this.selected_proponent.company = proponent.company.name;
      switch (this.transaction.proponent_type_id) {
        case 1:
          this.selected_proponent.type = "Employee";
          this.selected_proponent.number = proponent.employee_number;
          this.selected_proponent.cost_center = proponent.cost_center.name;
          break;
        case 2:
          this.selected_proponent.type = "Campaign";
          this.selected_proponent.number = proponent.campaign_number;
          this.selected_proponent.cost_center = proponent.cost_center.name;
          break;
        case 3:
          this.selected_proponent.type = "Site";
          break;
        default:
          break;
      }
      console.log(`selected ${JSON.stringify(this.selected_proponent)}`);
    },
    setSelectedAsset(asset) {
      this.selected_asset = {
        id: asset.id,
        name: asset.name,
        purchase_orders: asset.purchase_orders
      };
    },
  },
  computed: {
    ...mapGetters("proponent", ["proponent_types", "employees", "campaigns"]),
    ...mapGetters("site", ["sites"]),
    ...mapGetters("brand_model", ["brand_models"]),
    ...mapGetters("transaction", ["errors"]),
    searchedList() {
      switch (this.transaction.proponent_type_id) {
        case 1:
          return this.employees;
        case 2:
          return this.campaigns;
        case 3:
          return this.sites;
      }
    },
  },
  watch: {
    search_name(val) {
      let data = {
        search_name: val,
      };
      this.brandModelSearch(data);
    },
    "transaction.proponent_type_id": function (newVal, oldVal) {
      console.log(`value ${newVal}`);
      this.search = "";
      this.resetProponent();
    },
    // 'transaction.asset_type_id': function(val){
    //   this.changeAssetType();
    // },
  },
  mounted() {
    this.fetchProponentTypes();
  },
};
</script>

<style scoped>
.form-control {
  border: 1px solid #dededf;
  height: calc(1.5em + 0.75rem + 2px);
}

.search > .list-group-item {
  border-radius: 0;
}
.search > .list-group-item:hover {
  cursor: pointer;
  background: rgba(0, 0, 0, 0.05);
}
</style>