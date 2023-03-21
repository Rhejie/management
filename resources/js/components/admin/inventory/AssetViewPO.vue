<template>
    <div class="pt-5">
        <div class="container-fluid">
            <Breadcrumb />
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <a href="#" @click.prevent="back">< Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ asset.name }}</h4>
                            <button
                                @click.prevent="update(asset)"
                                type="button"
                                class="btn btn-sm btn-primary"
                            >
                                <i class="bi bi-pencil"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <h3 class="mt-4 mb-3">Classifications</h3>
                            <!-- Account Type -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Account Type</label>
                                    <p v-if="asset.purchase_order">
                                        <strong>{{
                                            asset.purchase_order.account_type.name
                                        }}</strong>
                                    </p>
                                </div>
                                <!-- Asset Type -->
                                <div class="form-group col-md-6">
                                    <label>Asset Type</label>
                                    <p v-if="asset.asset_class">
                                        <strong>{{
                                            asset.asset_class.asset_type_id == 0
                                                ? "Software/License Asset"
                                                : "Physical Asset"
                                        }}</strong>
                                    </p>
                                </div>
                            </div>
                            <!-- Details -->
                            <div>
                                <div class="row">
                                    <!-- Asset class -->
                                    <div class="form-group col-md-6">
                                        <label>Asset Class</label>
                                        <p v-if="asset.asset_class">
                                            <strong>{{
                                                asset.asset_class.name
                                            }}</strong>
                                        </p>
                                    </div>
                                    <!-- Subclass -->
                                    <div class="form-group col-md-6">
                                        <label>Asset Sub-class</label>
                                        <p v-if="asset.asset_subclass">
                                            <strong>{{
                                                asset.asset_subclass.name
                                            }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <hr />
                                <!-- row 1 -->
                                <h3 class="mt-4 mb-3">Asset Information</h3>
                                <div class="row">
                                    <!-- Brands -->
                                    <div class="form-group col-md-6">
                                        <label>Brands</label>
                                        <p v-if="asset.brand">
                                            <strong>{{
                                                asset.brand.name
                                            }}</strong>
                                        </p>
                                    </div>
                                    <!-- Brand Models -->
                                    <div class="form-group col-md-6">
                                        <label>Asset Name</label>
                                        <p v-if="asset.brand_model">
                                            <strong>{{ asset.brand_model.name }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <!-- row 1.2 -->
                                <div class="row">
                                    <!-- Brand Models -->
                                    <div class="form-group col-md">
                                        <label>Asset Description</label>
                                        <p v-if="asset.brand_model">
                                            <strong>{{
                                                asset.brand_model.description
                                            }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <hr />
                                <h3 class="mt-4 mb-3">Accounting Information</h3>
                                <div class="row">
                                    <div class="form-group">
                                        <label>Company</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.company.name }}</strong></p>
                                    </div>
                                </div>
                                <div v-if="asset.purchase_order" class="row">
                                    <!-- PO Number -->
                                    <div class="form-group col-md-6">
                                        <label>PO Number</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.po_number }}</strong></p>
                                    </div>
                                    <!-- Serial Number -->
                                    <div class="form-group col-md-6">
                                        <label>Serial number</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.serial_number }}</strong></p>
                                    </div>
                                </div>
                                <!-- row 2.2 -->
                                <div v-if="asset.purchase_order" class="row">
                                    <!-- quantity -->
                                    <!-- lifespan -->
                                    <div class="form-group col-md">
                                        <label>Quantity</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.quantity }}</strong></p>
                                    </div>
                                    <!-- ASSET VALUE -->
                                    <div class="form-group col-md">
                                        <label>Asset Value</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.asset_value }}</strong></p>
                                    </div>
                                    <!-- ACCOUNTING VALUE -->
                                    <!-- <div
                                        v-if="asset.purchase_order.account_type.id == 0"
                                        class="form-group col-md"
                                    > -->
                                    <div class="form-group col-md">
                                        <label>Accounting Value</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.accounting_value }}</strong></p>
                                    </div>
                                    <!-- Accumulated depreciation -->
                                    <!-- <div
                                        v-if="asset.purchase_order.account_type.id == 0"
                                        class="form-group col-md"
                                    > -->
                                    <div class="form-group col-md">
                                        <label>Accumulated depreciation</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.accumulated_depreciation }}</strong></p>
                                    </div>

                                    <!-- lifespan -->
                                    <div class="form-group col-md">
                                        <label>Lifespan in months</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.lifespan }}</strong></p>
                                    </div>
                                </div>
                                <!-- row 2.3 -->
                                <div class="form-row">
                                    <!-- WARRANTY DATE -->
                                    <div class="form-group col-md">
                                        <label>Warranty date</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.warranty_date }}</strong></p>
                                    </div>
                                </div>
                                <!-- row 2.4 -->
                                <div class="row">
                                    <!-- WARRANTY DESCRIPTION -->
                                    <div class="form-group col-md">
                                        <label>Warranty description</label>
                                        <p v-if="asset.purchase_order"><strong>{{ asset.purchase_order.warranty_description }}</strong></p>
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
import Breadcrumb from "../../layouts/Breadcrumb.vue";

export default {
    components: {
        Breadcrumb,
    },
    data: () => ({}),
    methods: {
        ...mapActions("inventory", ["setAssetType"]),
        ...mapActions("asset_summary", ["getAssetSummary", "setAssetSummary"]),
        update(asset) {
            this.setAssetSummary(asset);
            this.$router.push({ path: "/update-asset" });
            //   this.getAssetSummary(brand_model_id).then(() => {
            //     this.$router.push({ path: "/update-asset" });
            //   });
        },
        back() {
            this.$router.push({ path: "/asset-list" });
        },
    },
    computed: {
        ...mapGetters("inventory", ["asset", "asset_type"]),
    },
    created() {
        // console.log('AssetViewPO',this.asset)
        if (!Object.keys(this.asset).length) {
            if (this.asset.latest_asset) {
                this.asset.latest_asset.asset_type == 0
                    ? this.setAssetType(1)
                    : this.setAssetType(2);
            }

            this.$router.push({ path: "/asset-list" });
        }
    },
    mounted() {},
    watch: {},
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
    box-shadow: 0 5px 11px 0 rgba(0, 0, 0, 0.18),
        0 4px 15px 0 rgba(0, 0, 0, 0.15);
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
