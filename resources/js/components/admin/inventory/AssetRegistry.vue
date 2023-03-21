<template>
  <div>
    <div class="container-fluid">
      <div class="d-flex justify-content-start form-group mt-2">
        <div class="col-md-3">
          <input
            type="text"
            class="form-control"
            placeholder="Search PO Number"
            v-model="searchPONumber"
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
                <tr v-for="asset in filteredAssets" :key="asset.purchase_order.id">
                  <td>
                    <p>
                      <u><a
                        v-if="asset.purchase_order != null"
                        href="#"
                        @click.prevent="selected(asset.purchase_order)"
                        >{{ asset.purchase_order.po_number }}</a
                      ></u>
                    </p>
                  </td>
                  <td>
                    <p v-if="asset.purchase_order">
                      {{ asset.purchase_order.account_type.name }}
                    </p>
                  </td>
                  <td>
                    <p>{{ asset.asset_class.name }}</p>
                  </td>
                  <td>
                    <p>{{ asset.asset_subclass.name }}</p>
                  </td>
                  <td></td>
                  <td>
                    <p><u><a
                        v-if="asset.brand_model != null"
                        href="#"
                        @click.prevent="view_asset_po(asset)"
                        >{{ asset.brand_model.description }}</a>
                        </u></p>
                  </td>
                  <td></td>
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
    searchPONumber: "",
    headers:['PO Number','Account Type', 'Class', 'Sub-class', 'Asset Number', 'Asset Description', 'Cost Center'],
  }),
  methods: {
    ...mapActions("inventory", ["fetchInventoryAssets"]),
    ...mapActions("asset_summary", ["getAssetSummary"]),
    ...mapActions("purchase_order", ["selectPurchaseOrder"]),
    ...mapActions("inventory",[
        "setAsset",
        "setAssetType"
    ]),
    async update(brand_model_id) {
      await this.getAssetSummary(brand_model_id);
      // console.log(this.software_asset);

      this.$router.push({ path: "/update-asset" });
    },
    selected(purchase_order) {
      this.selectPurchaseOrder(purchase_order);
      this.$router.push({ path: "purchase-order" });
    },
    view_asset_po(asset)
    {
        this.setAssetType(0)
        this.setAsset(asset)
        this.$router.push({ path: "/asset-view-po" });
    }
  },
  computed: {
    ...mapGetters("inventory", ["assets", "errors"]),
    ...mapState({
      errors: (state) => state.software_asset.errors,
      purchase_order: (state) => state.purchase_order.purchase_order,
    }),
    filteredAssets() {
        console.log('filteredAssets',this.assets)
      let assets = this.assets;
      assets = this.assets.filter((asset) => {
        if (!asset.purchase_order) {
          return false;
        }
        return asset.purchase_order.po_number
          .toLowerCase()
          .includes(this.searchPONumber.toLowerCase());
      });
      return assets;
    },
  },
  created() {
    this.fetchInventoryAssets();
  },
  watch: {},
};
</script>
