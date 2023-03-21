<template>
    <div class="pt-5">
        <div class="container-fluid">
            <Breadcrumb />
            <div class="d-flex justify-content-start form-group mt-2">
                <div class="col-md-3 mt-3">
                    <a href="#" @click.prevent="back">< Back</a>
                </div>
                <!-- <div class="col-md-3">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search Item Code"
                        v-model="searchItemCode"
                    /> -->
                </div>
            </div>
            <div class="card">
                <div class="card-header flex-column align-items-start">
                    <h4 class="card-title">Purchase Order</h4>
                    <span class="card-text">{{ po_number }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th><strong>Item Code</strong></th>
                                    <th><strong>Item Description</strong></th>
                                    <th><strong>Quantity</strong></th>
                                    <th><strong>Unit Price</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="po in filteredAssets" :key="po.id">
                                    <td>{{ po.serial_number }}</td>
                                    <td v-if="po.brand_model">
                                        {{ po.brand_model.description }}
                                    </td>
                                    <td>{{ po.quantity }}</td>
                                    <td>{{ po.asset_value }}</td>
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
        searchItemCode: "",
    }),
    methods: {
        ...mapActions("purchase_order", ["fetchPurchaseOrder"]),
        back()
        {
            this.$router.push({ path: "/asset-list" });
        }
    },
    computed: {
        ...mapState({
            purchase_orders: (state) => state.purchase_order.purchase_orders,
            po_number: (state) => state.purchase_order.po_number,
        }),
        filteredAssets() {
            let purchase_orders = this.purchase_orders;
            purchase_orders = this.purchase_orders.filter((po) => {
                return po.serial_number
                    .toLowerCase()
                    .includes(this.searchItemCode.toLowerCase());
            });
            return purchase_orders;
        },
    },
    created() {
        this.fetchPurchaseOrder();
    },
    watch: {},
};
</script>
