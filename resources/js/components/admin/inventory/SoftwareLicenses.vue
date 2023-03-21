<template>
  <div>
    <div class="container-fluid">
      <div class="d-flex justify-content-start form-group mt-2">
        <div class="col-md-3">
          <input
            type="text"
            class="form-control"
            placeholder="Search names"
            v-model="searchName"
          />
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <table class="table table-responsive-md">
              <thead>
                <tr>
                  <th v-for="head in headers" :key="head">{{ head }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="filteredAssets.length == 0">
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
                <tr v-for="asset in filteredAssets" :key="asset.id">
                  <td v-if="asset.latest_po">
                    {{ asset.latest_po.account_type.name }}
                  </td>
                  <td v-else>{{ "--" }}</td>
                  <td>{{ asset.asset_class.name }}</td>
                  <td>{{ asset.asset_subclass.name }}</td>
                  <td>{{ asset.brand.name }}</td>
                  <td>
                    <u
                      ><a @click.prevent="view(asset)" href="#">
                        {{ asset.name }}
                      </a></u
                    >
                  </td>
                  <td>{{ asset.total_quantity }}</td>
                  <td>{{ asset.total_tagged }}</td>
                  <!-- <td class="d-flex">
                    <div class="row">
                      <div class="col">
                        <button
                          v-if="asset.total_purchase_orders != 0"
                          @click.prevent="view(asset)"
                          type="button"
                          class="btn btn-primary shadow btn-xs sharp mr-1"
                        >
                          <i class="bi bi-eye"></i>
                          View
                        </button>
                      </div>
                    </div>
                  </td> -->
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from "vuex";
export default {
  components: {},
  data: () => ({
    searchName: "",
    headers: ['Account Type', 'Class', 'Sub-class', 'Brand', 'Asset Name', 'Total Quantity', 'Total Tagged'],
  }),
  methods: {
    ...mapActions("software_asset", [
      "fetchSoftwareInventory",
      "getSoftwareAsset",
    ]),
    ...mapActions("asset_summary", [
      "getAssetSummary",
    ]),
    ...mapActions("inventory",[
        "setAsset",
        "setAssetType"
    ]),
    update(brand_model_id) {
      console.log(brand_model_id);
      this.getAssetSummary(brand_model_id).then(() => {
        this.$router.push({ path: "/update-asset" });
      });
      // console.log(this.software_asset);
    },
    view(asset){
        this.setAssetType(1)
        this.setAsset(asset)
        this.$router.push({ path: "/asset-view" });
    },
  },
  computed: {
    ...mapGetters("software_asset", [
      "software_assets",
      "software_asset",
      "errors",
    ]),
    ...mapState({ errors: (state) => state.software_asset.errors }),
    filteredAssets() {
      let assets = [];
      if (Object.keys(this.software_assets).length > 0) {
        
        assets = this.software_assets.filter((asset) => { 
            if(!asset.latest_po)
                return;

            return asset.name.toLowerCase().includes(this.searchName.toLowerCase());
        });
      }
      return assets;
    }
  },
  created() {
    // if (!Object.keys(this.software_assets).length)
        this.fetchSoftwareInventory();
  },
  watch: {},
};
</script>
