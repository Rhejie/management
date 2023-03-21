<template>
    <div class="pt-5">
        <div class="container-fluid">
            <Breadcrumb />
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Software Assets</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th><strong>Name</strong></th>
                                    <th><strong>Account Type</strong></th>
                                    <th><strong>Class</strong></th>
                                    <th><strong>Sub Class</strong></th>
                                    <th><strong>Brand</strong></th>
                                    <th><strong>P.O. Number</strong></th>
                                    <th><strong>Asset Number</strong></th>
                                    <th><strong>Date Acquired</strong></th>
                                    <th><strong>Expiration Date</strong></th>
                                    <th><strong>Expired</strong></th>
                                    <th><strong>Action</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(software_asset, index) in software_assets" :key="software_asset.id">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ software_asset.brand_model.name }}</td>
                                    <td>{{ software_asset.account_type.name }}</td>
                                    <td>{{ software_asset.asset_class.name }}</td>
                                    <td>{{ software_asset.asset_subclass.name }}</td>
                                    <td>{{ software_asset.brand.name }}</td>
                                    <td>{{ software_asset.purchase_order.po_number }}</td>
                                    <td>{{ software_asset.purchase_order.asset_number }}</td>
                                    <td>{{ software_asset.purchase_order.date_acquired }}</td>
                                    <td>{{ software_asset.purchase_order.expiration_date }}</td>
                                    <td>{{ software_asset.purchase_order.isExpired }}</td>
                                    <td class="d-flex">
                                        <div class="row">
                                            <div class="col">
                                                <button
                                                    @click.prevent="update(software_asset.id)"
                                                    type="button"
                                                    class="btn btn-primary shadow btn-xs sharp mr-1"
                                                >
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <!-- <button
                                                    type="button"
                                                    class="btn btn-danger shadow btn-xs sharp"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button> -->
                                            </div>
                                        </div>
                                    </td>
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
        
    }),
    methods: {
        ...mapActions("software_asset", ["fetchSoftwareInventory","getSoftwareAsset"]),
        async update(id)
        {
            await this.getSoftwareAsset(id);
            // console.log(this.software_asset);

            this.$router.push({ path: "/update-asset" });
        }
    },
    computed: {
        ...mapGetters("software_asset", ["software_assets","software_asset","errors"]),
        ...mapState({ errors: (state) => state.software_asset.errors}),
    },
    created() {
        // this.fetchSoftwareAssets();
        this.fetchSoftwareInventory();
    },
    watch: {},
};
</script>
