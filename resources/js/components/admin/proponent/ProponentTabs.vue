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
                <employee-list v-if="currentIndex == 0" />
                <campaign-list v-if="currentIndex == 1" />
                <site-list v-if="currentIndex == 2" />
              </div>
            </div>
          </div>
        </div>

        <!-- end modal -->
      </div>
    </div>
  </div>
</template>

<script>
import Breadcrumb from "../../layouts/Breadcrumb.vue";
import EmployeeList from "./EmployeeList.vue";
import CampaignList from "./CampaignList.vue";
import SiteList from "./SiteList.vue";
import { mapActions } from 'vuex';

export default {
  components: {
    Breadcrumb,
    EmployeeList,
    CampaignList,
    SiteList,
  },
  data: () => ({
    currentIndex: 0,
    headers: ["Employee List", "Campaign List", "Site List"],
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