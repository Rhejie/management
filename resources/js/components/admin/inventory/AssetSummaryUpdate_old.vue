<template>
  <div class="pt-5">
    <div class="container-fluid">
      <Breadcrumb />
      <!-- row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Asset Summary</h4>
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
                          v-model="asset_summary.latest_po.account_type"
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
                    <!-- Asset Type -->
                    <div class="form-group col-md-6">
                      <label>
                        Asset Type
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-select fs-3"
                          v-model="asset_summary.asset_class.asset_type_id"
                          required
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
                      </div>
                    </div>
                  </div>
                  <!-- Class -->
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>
                        Asset Class
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-select fs-3"
                          v-model="asset_summary.asset_class.id"
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
                    <!-- Asset Type -->
                    <div class="form-group col-md-6">
                      <label>
                        Class Code
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input v-model="asset_summary.asset_class.sap_code" type="text" class="form-control">
                      </div>
                    </div>
                  </div>
                  <!-- Details -->
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

export default {
  components: {
    DatePicker,
    Breadcrumb,
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
    isLoading: false,
  }),
  methods: {
    ...mapActions("asset_class", ["fetchAssetClasses"]),
    ...mapActions("brands", ["fetchBrands"]),
    ...mapActions("cost_center", ["fetchCostCenters"]),
    ...mapActions("purchase_order", ["fetchPurchaseOrders"]),
    ...mapActions("company", ["fetchCompanies"]),
    ...mapActions("physical_asset", ["fetchPhysicalAssets"]),
    ...mapActions("software_asset", ["createSoftwareAsset"]),

    async validate() {
      //   if(this.asset.asset_type_id == 2)
      //     await this.updateSoftwareAsset(this.asset);

      //   if(Object.keys(this.errors).length == 0)
      //     this.$router.push({ path: "/software-licenses" });

      console.log(`entries ${JSON.stringify(this.asset)}`);
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
    ...mapGetters("asset_summary", ["asset_summary"]),
    ...mapGetters("asset_class", ["asset_classes", "asset_class"]),
    ...mapGetters("brands", ["allBrands"]),
    ...mapGetters("cost_center", ["cost_centers"]),
    ...mapGetters("purchase_order", ["purchase_orders"]),
    ...mapGetters("company", ["companies"]),
    ...mapGetters("physical_asset", ["physical_assets"]),
    ...mapGetters("software_asset", ["software_asset", "errors"]),
    // ...mapState({ errors: (state) => state.software_asset.errors}),
  },
  beforeMount(){
    if (Object.keys(this.asset_summary).length === 0) {
      this.$router.back();
    }
  },
  mounted() {
    this.fetchAssetClasses();
    this.fetchBrands();
    this.fetchCostCenters();
    this.fetchPurchaseOrders();
    this.fetchCompanies();
    this.fetchPhysicalAssets();
    // this.fetchAssetSubClasses(this.asset.asset_class_id);
    // this.sub_classes = assetclass.sub_classes;
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
