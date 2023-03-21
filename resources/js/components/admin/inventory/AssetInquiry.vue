<template>
    <div class="pt-5">
        <div class="container-fluid">
            <Breadcrumb />
            <div class="d-flex justify-content-end form-group mt-2">
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
                <div class="card-header">
                    <h4 class="card-title">Asset Inquiry</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th><strong>Account Type</strong></th>
                                    <th><strong>Asset Type</strong></th>
                                    <th><strong>Class</strong></th>
                                    <th><strong>Sub-class</strong></th>
                                    <th><strong>Brand</strong></th>
                                    <th><strong>Asset Name</strong></th>
                                    <th><strong>Quantity</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="asset in filteredAssets"
                                    :key="asset.brand_model_id"
                                >
                                    <td>{{ asset.account_type.name }}</td>
                                    <td>
                                        {{
                                            asset.asset_type == 0
                                                ? "Software/Licenses"
                                                : "Physical"
                                        }}
                                    </td>
                                    <td>{{ asset.asset_class.name }}</td>
                                    <td>{{ asset.asset_subclass.name }}</td>
                                    <td>{{ asset.brand.name }}</td>
                                    <td>{{ asset.brand_model.name }}</td>
                                    <td>{{ asset.purchase_order.quantity }}</td>
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
import Breadcrumb from "../../layouts/Breadcrumb.vue";
import { mapActions, mapGetters, mapState } from "vuex";
export default {
    components: {
        Breadcrumb,
    },
    data: () => ({
        searchName: "",
    }),
    methods: {
        ...mapActions("inventory", [
            "fetchInventoryAssets",
        ]),
        ...mapActions("asset_summary", ["getAssetSummary"]),
        async update(brand_model_id) {
            await this.getAssetSummary(brand_model_id);
            // console.log(this.software_asset);

            this.$router.push({ path: "/update-asset" });
        },
    },
    computed: {
        ...mapGetters("inventory", [
            "assets",
            "errors",
        ]),
        ...mapState({ errors: (state) => state.software_asset.errors }),
        filteredAssets() {
            let assets = this.assets;
            assets = this.assets.filter((asset) => {
                return asset.brand_model.name
                    .toLowerCase()
                    .includes(this.searchName.toLowerCase());
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
