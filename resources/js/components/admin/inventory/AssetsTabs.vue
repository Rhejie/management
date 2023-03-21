<template>
  <div>
    <div class="pt-5">
      <div class="container-fluid">
        <Breadcrumb />
        <ul class="nav nav-tabs">
          <li v-for="(header, index) in headers" :key="index" class="nav-item">
            <a
              :class="currentIndex == index ? 'active' : ''"
              class="nav-link"
              href="#"
              @click.prevent="changeTab(index)"
              >{{ header }}</a
            >
          </li>
        </ul>

        <div class="tab-content">
          <div
            class="tab-pane fade show active"
            id="home"
            role="tabpanel"
            aria-labelledby="home-tab"
          >
            <div class="card rounded-0">
              <div class="card-body">
                <asset-registry v-if="currentIndex == 0" />
                <software-assets v-if="currentIndex == 1" />
                <physical-assets v-if="currentIndex == 2" />
              </div>
            </div>
          </div>
        </div>

        <!-- end tab -->
      </div>
    </div>
  </div>
</template>

<script>
import Breadcrumb from "../../layouts/Breadcrumb.vue";
import AssetRegistry from "./AssetRegistry.vue"
import SoftwareAssets from "./SoftwareLicenses.vue"
import PhysicalAssets from "./PhysicalAssets.vue"
import { mapActions, mapGetters, mapState } from "vuex";

export default {
  components: {
    Breadcrumb,
    AssetRegistry,
    SoftwareAssets,
    PhysicalAssets,
  },
  data: () => ({
    currentIndex: 0,
    headers: ["Asset Registry List", "Software/Licenses List", "Physical Assets List"],
  }),
  methods: {
    changeTab(index) {
      this.currentIndex = index;
    },
  },
  computed: {
      ...mapGetters("inventory",["asset_type"])
  },
  created() {
      if(this.asset_type)
        this.currentIndex = this.asset_type
  }
};
</script>

<style scoped>
.nav-link.active{
    background-color: #ffffff;
}

.tab-content > .active > .card{
    border-left: 1px solid #dee2e6;
    border-right: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
}
</style>