<template>
    <div class="justify-content-center pt-5">
        <Breadcrumb />
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Entity Quantity Allocation of Assets</h4>
            </div>
            <form>
                <div class="card-body px-5 pt-5">
                    <div class="row mb-5 align-items-center">
                        <label class="col-sm-2 col-form-label">Asset Type</label>
                        <div class="col-sm">
                            <select
                                class="form-select fs-3"
                                v-model="asset_type_id"
                                required
                                @change="searchByType"
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
                            <span v-if="isFetchingData && nextStep == 0">Fetching data ...</span>
                        </div>
                    </div>
                    <div v-if="nextStep !== 0" class="row mb-5 align-items-center">
                        <label class="col-sm-2 col-form-label">Asset Name</label>
                        <div class="col-sm">
                            <model-list-select
                                :list="assets"
                                v-model="asset"
                                option-value="id"
                                option-text="name"
                                placeholder="Select Asset"
                            >
                            </model-list-select>
                            <span v-if="isFetchingData && nextStep == 1">Fetching data ...</span>
                        </div>
                    </div>

                    <!-- <div v-if="asset.total_quantity !== null && !isFetchingData"> -->
                    <div v-if="asset.total_quantity !== null">
                        <div class="row mb-5 align-items-center">
                            <label class="col-sm-2 col-form-label">Total Quantity</label>
                            <div class="col-sm">
                                <span>{{ asset.total_quantity }}</span>
                            </div>
                        </div>
                        
                        <div>
                            <h4><strong>Entity</strong></h4>
                            <div v-for="company of companies" :key="company.id">
                                <div class="row mb-5 align-items-center">
                                    <label class="col-sm-2 col-form-label">{{ company.name }}</label>
                                    <div class="col-sm">
                                        <input 
                                            onkeypress="return !(event.charCode == 46) || !(event.charCode == 13)"
                                            pattern="[0-9]"
                                            type="number" 
                                            class="form-control fs-4 entity"
                                            :data-id="company.id"
                                            @change="updateTotalEntity"
                                            @keypress.enter.prevent
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="mb-3 row justify-content-md-end">
                            <label id="total_allocated" class="col-auto col-form-label">Total Allocated Quantity : {{ total_entity_qty }}</label>
                        </div>
                        <!-- <div v-if="error" class="alert alert-danger d-flex justify-content-center align-items-center top-0" role="alert">Invalid Quantity</div> -->
                        <div class="mb-3 row justify-content-md-end">
                            <div class="col-auto">
                                <button :disabled="isLoading" type="submit" class="btn btn-primary" @click.prevent="validate">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center top-0" style="min-height: 200px;">
                <div class="toast" id="success" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Quantity Allocation</strong>
                        <small>11 mins ago</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        Success!.
                    </div>
                </div>
            </div> -->
            <div
                class="modal fade show"
                tabindex="-1"
                id="showError"
                data-bs-backdrop="static"
                aria-labelledby="showError"
                aria-hidden="true"
                v-if="showError"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                @click.prevent="toggleError"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <p>Invalid Quntity!</p>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-dark"
                                @click.prevent="toggleError"
                            >
                                Ok
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Breadcrumb from "../../layouts/Breadcrumb.vue";
import { ModelListSelect } from "vue-search-select";
import { Modal, Tooltip, Toast } from "bootstrap";

export default {
    components: {
        Breadcrumb,
        ModelListSelect,
    },
    data: () => ({
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
        asset_type_id: null,
        assets: [],
        asset: {
            total_quantity: null
        },
        error: false,
        success: false,
        isLoading: false,
        data: {
            asset_id:null,
            entities:[],
            asset_type_id:null,
        },
        qcompany:[],
        nextStep: 0,
        isFetchingData: false,
        showError: false,
        total_entity_qty: 0,
    }),
    methods: {
        ...mapActions("software_asset",["fetchSoftwareInventory"]),
        ...mapActions("physical_asset",["fetchPhysicalAssetInventory"]),
        ...mapActions("inventory",["saveAllocation","fetchQuantityAllocation","resetList"]),
        ...mapActions("company", ["fetchCompanies"]),
        async searchByType() {
            this.resetSteps();
            this.asset.total_quantity = null;
            this.isFetchingData = true;
            if(this.asset_type_id === 0){
                await this.fetchSoftwareInventory();
                this.assets = this.software_assets
            }else{
                await this.fetchPhysicalAssetInventory();
                this.assets = this.physical_assets
            }
            this.isFetchingData = false;
            this.nextStep++
        },
        resetSteps()
        {
            this.nextStep = 0;
        },
        toggleError()
        {
            this.showError = !this.showError;
        },
        updateTotalEntity()
        {
            let total_allocated_elem = document.getElementById("total_allocated");
            
            this.total_entity_qty = this.calculateQuantity();
            
            if(this.total_entity_qty > this.asset.total_quantity)
                total_allocated_elem.classList.add('alert-danger')
            else
                total_allocated_elem.classList.remove('alert-danger')
        },
        calculateQuantity() {
            // this.data = {
            //     asset_id:null,
            //     entities:[],
            //     asset_type_id:null,
            // }
            
            let entity = document.querySelectorAll('.entity')
            var total = 0;
            for(let i=0;i<entity.length;i++)
            {
                var currVal = (entity[i].value) ? parseInt(entity[i].value) : 0;
                this.data.entities.push({
                    id: entity[i].dataset.id, 
                    quantity: currVal
                })
                total += currVal;
            }

            return total;
        },
        async validate(e)
        {
            console.log(e)
            console.log(window.event.keyCode)
            console.log(e.keyCode);
            console.log('validating')
            this.isLoading = true;
            this.reset()
            
            let total = this.calculateQuantity();

            if(total > this.asset.total_quantity || total == 0)
            {
                this.error = true;
                document.querySelectorAll('.entity').forEach(x=>x.classList.add('is-invalid'))
            }

            this.data.asset_id = this.asset.id
            this.data.asset_type_id = this.asset_type_id

            if(this.error) //Quantity Error
            {
                this.isLoading = false;
                this.toggleError()
                return false;
            }

            if(!this.error)
                await this.saveAllocation(this.data)

            if (!Object.keys(this.errors).length) {
                var success = document.getElementById('success');
                var toast = new Toast(success)
                toast.show()
            };

            this.isLoading = false;
        },
        reset()
        {
            this.error = false;
            this.data = {
                asset_id:null,
                entities:[],
                asset_type_id:null,
            }
            document.querySelectorAll('.entity').forEach(x=>x.classList.remove('is-invalid'))
        },
        async populate()
        {
            this.isFetchingData = true;
            await this.fetchQuantityAllocation({asset_id: this.asset.id})
            let entity = document.querySelectorAll('.entity')
            
            for(let i=0;i<entity.length;i++)
            {
                var id = entity[i].dataset.id;
                let qty_allocation = this.quantity_allocations.find(function(r){
                    return r.company_id == id
                })
                
                if(qty_allocation)
                {
                    let qty = qty_allocation.quantity_allocation
                    entity[i].value = qty;
                    this.total_entity_qty += qty;
                }
                    
            }
            this.isFetchingData = false;
        }

    },
    mounted() {
        this.fetchCompanies()
    },
    computed: {
        ...mapGetters("inventory", ["errors","quantity_allocations"]),
        ...mapGetters("company", ["companies"]),
        ...mapGetters("physical_asset", ["physical_assets"]),
        ...mapGetters("software_asset", [
            "software_assets",
            "software_asset",
            "errors",
        ]),
    },
    watch: {
        asset: function (id) {
            // console.log(this.asset.total_quantity)
            if(id) {
                this.total_entity_qty = 0;
                this.assets.find(function(r){
                    return r.id == id
                })

                this.resetList()
                this.populate()
            }
        },
    },
};
</script>

<style scoped>
.feedback > i {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.ui.search.selection.dropdown > input.search,
.ui.search.selection.dropdown > span.sizer {
    line-height: 1.21428571em;
    padding: 0.67857143em 2.1em 0.67857143em 1em;
}

.form-control {
  border: 1px solid #dededf;
}
.is-invalid {
  border: 1px solid red;
  border-right: 1px solid red !important;
}
</style>
