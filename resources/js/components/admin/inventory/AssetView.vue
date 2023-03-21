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
              <button @click.prevent="update(asset)" type="button" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></button>
            </div>
            <div class="card-body">
              <div class="form-validation">
                  <h3 class="mt-4 mb-3">Classifications</h3>
                  <!-- Account Type -->
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Account Type</label>
                      <p v-if="asset.latest_po"><strong>{{ asset.latest_po.account_type.name }}</strong></p>
                    </div>
                    <!-- Asset Type -->
                    <div class="form-group col-md-6">
                      <label>Asset Type</label>
                      <p><strong>{{ asset_type == 1 ? 'Software/License Asset':'Physical Asset'}}</strong></p>
                    </div>
                  </div>
                  <!-- Details -->
                  <div>
                    <div class="row">
                      <!-- Asset class -->
                      <div class="form-group col-md-6">
                        <label>Asset Class</label>
                        <p v-if="asset.asset_class"><strong>{{ asset.asset_class.name }}</strong></p>
                      </div>
                      <!-- Subclass -->
                      <div class="form-group col-md-6">
                        <label>Asset Sub-class</label>
                        <p v-if="asset.asset_subclass"><strong>{{ asset.asset_subclass.name }}</strong></p>
                      </div>
                    </div>
                    <hr />
                    <!-- row 1 -->
                    <h3 class="mt-4 mb-3">Asset Information</h3>
                    <div class="row">
                      <!-- Brands -->
                      <div class="form-group col-md-6">
                        <label>Brands</label>
                        <p v-if="asset.brand"><strong>{{ asset.brand.name }}</strong></p>
                      </div>
                      <!-- Brand Models -->
                      <div class="form-group col-md-6">
                        <label>Asset Name</label>
                        <p><strong>{{ asset.name }}</strong></p>
                      </div>
                    </div>
                    <!-- row 1.2 -->
                    <div class="row">
                      <!-- Brand Models -->
                      <div class="form-group col-md">
                        <label>Asset Description</label>
                        <p><strong>{{ asset.description }}</strong></p>
                      </div>
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
  data: () => ({
  }),
  methods: {
    ...mapActions("inventory", ["setAssetType"]),
    ...mapActions("asset_summary", [
      "getAssetSummary",
      "setAssetSummary"
    ]),
    update(asset){
        this.setAssetSummary(asset);
        this.$router.push({ path: "/update-asset" });
    //   this.getAssetSummary(brand_model_id).then(() => {
    //     this.$router.push({ path: "/update-asset" });
    //   });
    },
    back()
    {
        this.$router.push({ path: "/asset-list" });
    }
  },
  computed: {
    ...mapGetters("inventory",["asset","asset_type"]),
  },
  created()
  {
        if(!Object.keys(this.asset).length)
        {
            if(this.asset.latest_asset)
            {
                this.asset.latest_asset.asset_type == 0
                ? this.setAssetType(1)
                : this.setAssetType(2)
            }
            
            this.$router.push({ path: "/asset-list" });
        }
  },
  mounted() {
    
  },
  watch: {
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

.invalid-feedback{
  display: block;
}

.form-control {
  height: calc(1.5em + 0.75rem + 2px);
}
</style>
