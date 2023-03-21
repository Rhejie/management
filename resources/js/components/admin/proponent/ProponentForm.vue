<template>
  <div class="pt-5">
    <div class="container-fluid">
      <Breadcrumb />
      <!-- row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Add Asset User</h4>
            </div>
            <div class="card-body">
              <div class="form-validation">
                <form class="form-validate" action="#" method="post">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>
                        Asset User Type
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-select fs-5"
                          v-model="proponent.proponent_type_id"
                          @change="headerChange(proponent.proponent_type_id)"
                          required
                        >
                          <option
                            class="fs-5"
                            v-for="proponent_type in proponent_types"
                            :key="proponent_type.id"
                            :value="proponent_type.id"
                          >
                            {{ proponent_type.type }}
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div v-if="proponent.proponent_type_id" class="form-row">
                    <!-- Entity -->
                    <div class="form-group col-md-6">
                      <label>
                        Company
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-select fs-5"
                          v-model="proponent.company_id"
                          @change="companyChange"
                          required
                        >
                          <option :value="null" class="fs-5">
                            Select Company
                          </option>
                          <option
                            class="fs-5"
                            v-for="company in companies"
                            :key="company.id"
                            :value="company.id"
                          >
                            {{ company.name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- Site -->
                    <div
                      v-if="proponent.proponent_type_id < 3"
                      class="form-group col-md-6"
                    >
                      <label>
                        Site
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          v-if="proponent.proponent_type_id == 1"
                          class="form-select fs-5"
                          v-model="proponent.site_id"
                          required
                          @change="siteChange"
                        >
                          <option
                            class="fs-5"
                            v-for="site in selected_sites"
                            :key="site.id"
                            :value="site.id"
                          >
                            {{ site.name }}
                          </option>
                        </select>

                        <select
                          v-else
                          class="form-select fs-5"
                          v-model="proponent.site_id"
                          required
                        >
                          <option
                            class="fs-5"
                            v-for="site in selected_sites"
                            :key="site.id"
                            :value="site.id"
                          >
                            {{ site.name }}
                          </option>
                        </select>

                        <div v-if="errors.error">
                          <ul>
                            <ul>
                              <li
                                v-for="(error, index) in errors.message.site_id"
                                :key="index"
                              >
                                <i class="text-danger">{{ error }}</i>
                              </li>
                            </ul>
                          </ul>
                        </div>

                        <div class="mt-1" v-if="site_errors.error">
                          <ul>
                            <li
                              v-for="(error, index) in errors.message.name"
                              :key="index"
                            >
                              <i class="text-danger">{{ error }}</i>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <!-- Cost centers -->
                    <div
                      v-if="proponent.proponent_type_id == 2"
                      class="form-group col-md-6"
                    >
                      <label>
                        Cost Center
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-select fs-5"
                          v-model="proponent.cost_center_id"
                          required
                        >
                          <option
                            class="fs-5"
                            v-for="cost_center in cost_centers"
                            :key="cost_center.id"
                            :value="cost_center.id"
                          >
                            {{ cost_center.name }}
                          </option>
                        </select>

                        <div v-if="errors.error">
                          <ul>
                            <ul>
                              <li
                                v-for="(error, index) in errors.message
                                  .cost_center_id"
                                :key="index"
                              >
                                <i class="text-danger">{{ error }}</i>
                              </li>
                            </ul>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <!-- Campaign -->
                    <div
                      v-if="proponent.proponent_type_id == 1"
                      class="form-group col-md-6"
                    >
                      <label>
                        Campaign
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <select
                          class="form-select fs-5"
                          v-model="proponent.campaign_id"
                          required
                        >
                          <option
                            class="fs-5"
                            v-for="campaign in campaigns"
                            :key="campaign.id"
                            :value="campaign.id"
                          >
                            {{ campaign.name }}
                          </option>
                        </select>

                        <div v-if="errors.error">
                          <ul>
                            <ul>
                              <li
                                v-for="(error, index) in errors.message
                                  .campaign_id"
                                :key="index"
                              >
                                <i class="text-danger">{{ error }}</i>
                              </li>
                            </ul>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <!-- Email -->
                    <div
                      v-if="proponent.proponent_type_id == 1"
                      class="form-group col-md-6"
                    >
                      <label>
                        {{ header_type }} Email
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="email"
                          class="form-control fs-5"
                          v-model="proponent.email"
                        />
                        <div v-if="errors.error">
                          <ul>
                            <ul>
                              <li
                                v-for="(error, index) in errors.message.email"
                                :key="index"
                              >
                                <i class="text-danger">{{ error }}</i>
                              </li>
                            </ul>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <!-- Proponent Number -->
                    <div
                      v-if="proponent.proponent_type_id < 3"
                      class="form-group col-md-6"
                    >
                      <label>
                        {{ header_type }} Number
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="text"
                          class="form-control fs-5"
                          v-model="proponent.proponent_number"
                        />
                        <div v-if="errors.error">
                          <ul>
                            <ul>
                              <li
                                v-for="(error, index) in errors.message
                                  .proponent_number"
                                :key="index"
                              >
                                <i class="text-danger">{{ error }}</i>
                              </li>
                            </ul>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <!-- Proponent Name -->
                    <div class="form-group col-md-6">
                      <label>
                        {{ header_type }} Name
                        <span class="text-danger">*</span>
                      </label>
                      <div>
                        <input
                          type="text"
                          class="form-control fs-5"
                          v-model="proponent.name"
                        />
                        <div v-if="errors.error">
                          <ul>
                            <ul>
                              <li
                                v-for="(error, index) in errors.message.name"
                                :key="index"
                              >
                                <i class="text-danger">{{ error }}</i>
                              </li>
                            </ul>
                          </ul>
                        </div>

                        <div v-if="site_errors.error">
                          <ul>
                            <ul>
                              <li>
                                <i class="text-danger">{{ site_errors.message.proponent_name }}</i>
                              </li>
                            </ul>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <!-- end of form -->
                  </div>

                  <!-- Submit -->

                  <div
                    v-if="proponent.proponent_type_id != null"
                    class="form-group row"
                  >
                    <div class="col-md-12 ml-auto">
                      <button
                        type="submit"
                        class="btn btn-primary"
                        @click.prevent="validate"
                      >
                        Submit
                      </button>
                    </div>
                  </div>
                </form>
              </div>
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

export default {
  components: {
    Breadcrumb,
  },
  data: () => ({
    header_type: "",
    proponent: {
      id: null,
      company_id: null,
      proponent_type_id: null,
      proponent_number: null,
      site_id: null,
      cost_center_id: null,
      campaign_id: null,
      tagged_proponent_id: null,
      email: "",
    },
  }),
  methods: {
    ...mapActions("proponent", [
      "fetchProponentTypes",
      "fetchCampaigns",
      "fetchSelectedCampaigns",
      "createCampaign",
      "resetCampaigns",
      "createEmployee",
      "resetError",
    ]),
    ...mapActions("company", ["fetchCompanies"]),
    ...mapActions("site", [
      "fetchSelectedSites",
      "resetSelectedSites",
      "createSite",
      "resetSiteError",
    ]),
    ...mapActions("cost_center", ["fetchCostCenters"]),
    validate() {
      switch (this.proponent.proponent_type_id) {
        case 1:
          this.createEmployee(this.proponent).then(() => {
            if (!this.errors.error) {
              this.$router.push({ path: "/proponent-list" });
            }
          });
          break;
        case 2:
          this.createCampaign(this.proponent).then(() => {
            if (!this.errors.error) {
              this.$router.push({ path: "/proponent-list" });
            }
          });
          break;
        case 3:
          this.createSite(this.proponent).then(() => {
            if (!this.site_errors.error) {
              this.$router.push({ path: "/proponent-list" });
            }
          });
          break;
        default:
          break;
      }
    },
    nullify() {
      // this.proponent.proponent_number = null;
      this.proponent.site_id = null;
      // this.proponent.cost_center_id = null;
      this.proponent.tagged_proponent_id = null;
    },
    headerChange(proponent_type_id) {
      let proponent_type = this.proponent_types.find(function (item) {
        return item.id == proponent_type_id;
      });
      this.resetError();
      this.resetSiteError();
      this.header_type = proponent_type.type;
      this.proponent.company_id = null;
      this.proponent.proponent_number = null;
      this.nullify();
    },
    companyChange() {
      if (this.proponent.company_id != null) {
        let company_id = this.proponent.company_id;
        let company = this.companies.find(function (item) {
          return item.id == company_id;
        });
        this.fetchSelectedSites(company.slug);
        this.proponent.site_id = null;
        this.proponent.campaign_id = null;
        this.resetCampaigns();
      }
      this.nullify();
    },
    siteChange() {
      if (this.proponent.site_id != null) {
        let site_id = this.proponent.site_id;
        let site = this.selected_sites.find(function (item) {
          return item.id == site_id;
        });
        this.fetchSelectedCampaigns(site.id);
      }
      this.proponent.campaign_id = null;
    },
  },
  computed: {
    ...mapGetters("proponent", ["proponent_types", "campaigns", "errors"]),
    ...mapGetters("company", ["companies"]),
    ...mapGetters("site", ["selected_sites", "site_errors"]),
    ...mapGetters("cost_center", ["cost_centers"]),
  },
  mounted() {
    this.fetchProponentTypes();
    this.fetchCompanies();
    this.fetchCostCenters();
    this.resetError();
    this.resetSiteError();
    // this.fetchCampaigns();
  },
  watch: {},
};
</script>

<style scoped>
.form-control {
  height: calc(1.5em + 0.75rem + 2px);
}
</style>