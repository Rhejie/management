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
                <asset-classes v-if="currentIndex == 0" />
                <asset-sub-classes v-if="currentIndex == 1" />
                <brands v-if="currentIndex == 2" />
                <brand-models v-if="currentIndex == 3" />
                <segments v-if="currentIndex == 4" />
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
import AssetClasses from "./AssetClasses.vue"
import AssetSubClasses from "./AssetSubClasses.vue"
import Brands from "./Brands.vue"
import BrandModels from "./BrandModels.vue"
import Segments from "./Segments.vue"

export default {
  components: {
    Breadcrumb,
    AssetClasses,
    AssetSubClasses,
    Brands,
    BrandModels,
    Segments,
  },
  data: () => ({
    currentIndex: 0,
    headers: ["Asset Class List", "Asset Subclass List", "Brand List", "Brand Model List", "Segment List"],
  }),
  methods: {
    changeTab(index) {
      this.currentIndex = index;
    },
  },
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