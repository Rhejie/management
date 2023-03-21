<template>
  <div>
    <div class="container-fluid">
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
      <table class="table table-bordered">
        <thead>
          <th v-for="head in headers" :key="head">{{ head }}</th>
        </thead>
        <tbody>
          <tr v-if="filteredCampaigns.length < 1 && searchName == ''">
            <td :colspan="headers.length">
              <div class="d-flex align-items-center">
                <strong>Loading...</strong>
                <div
                  class="spinner-border ms-auto"
                  role="status"
                  aria-hidden="true"
                ></div>
              </div>
            </td>
          </tr>
          <tr v-else v-for="campaign in filteredCampaigns" :key="campaign.id">
            <td>{{ campaign.name }}</td>
            <td>{{ campaign.campaign_number }}</td>
            <td>{{ campaign.site.name }}</td>
            <td>
              <button
                @click.prevent="selectCampaign(campaign)"
                class="btn btn-primary shadow btn-xs sharp mr-1"
              >
                <i class="bi bi-pencil-fill"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div
        class="modal fade show"
        id="exampleModalCenter"
        tabindex="-1"
        aria-labelledby="exampleModalCenterTitle"
        aria-modal="true"
        role="dialog"
        v-if="show"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Campaign Update</h5>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col">
                  <div class="mb-3 row">
                    <label class="col-form-label mt-2">Company</label>
                    <div class="col-sm">
                      <select
                        v-model="campaign.company_id"
                        class="form-control form-select form-select-md"
                        required
                        @change="companyChange"
                      >
                        <option
                          v-for="company in companies"
                          :key="company.id"
                          :value="company.id"
                        >
                          {{ company.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="mb-3 row">
                    <label class="col-form-label mt-2">Site</label>
                    <div class="col-sm">
                      <select
                        v-model="campaign.site_id"
                        class="form-control form-select form-select-md"
                        required
                      >
                        <option
                          v-for="site in selected_sites"
                          :key="site.id"
                          :value="site.id"
                        >
                          {{ site.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="mb-3 row">
                    <label class="col-form-label mt-2">Cost Center</label>
                    <div class="col-sm">
                      <select
                        v-model="campaign.cost_center_id"
                        class="form-control form-select form-select-md"
                        required
                      >
                        <option
                          v-for="cost_center in cost_centers"
                          :key="cost_center.id"
                          :value="cost_center.id"
                        >
                          {{ cost_center.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="mb-3 row">
                    <label class="col-form-label mt-2">Name</label>
                    <div class="col-sm">
                      <input
                        v-model="campaign.name"
                        type="text"
                        class="form-control"
                        required
                      />
                      <div class="feedback" v-if="errors.error">
                        <i v-for="error in errors.message.name" :key="error">{{
                          error
                        }}</i>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="mb-3 row">
                    <label class="col-form-label mt-2">Campaign Number</label>
                    <div class="col-sm">
                      <input
                        v-model="campaign.proponent_number"
                        type="text"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                @click="toggleOpen"
              >
                Close
              </button>
              <button
                type="button"
                class="btn btn-primary"
                @click.prevent="submitForm"
              >
                Save changes
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal -->
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  data: () => ({
    searchName: "",
    show: false,
    headers: ["Name", "Campaign Number", "Site", "Actions"],
    campaign: {
      id: null,
      name: "",
      proponent_number: "",
      site_id: null,
      company_id: null,
      cost_center_id: null,
    },
  }),
  methods: {
    ...mapActions("proponent", [
      "fetchCampaigns",
      "updateCampaign",
      "resetError",
    ]),
    ...mapActions("company", ["fetchCompanies"]),
    ...mapActions("site", ["fetchSelectedSites"]),
    ...mapActions("cost_center", ["fetchCostCenters"]),

    toggleOpen() {
      this.show = !this.show;
    },
    selectCampaign(campaign) {
      this.campaign = {
        id: campaign.id,
        name: campaign.name,
        proponent_number: campaign.campaign_number,
        site_id: campaign.site.id,
        company_id: campaign.site.company_id,
        cost_center_id: campaign.cost_center_id,
      };
      this.resetError();
      this.searchCompany();
      this.toggleOpen();
    },
    submitForm() {
      this.updateCampaign(this.campaign).then(() => {
        if (!this.errors.error) {
          this.fetchCampaigns();
          this.toggleOpen();
        }
      });
    },
    companyChange() {
      this.searchCompany();
      this.campaign.site_id = null;
    },
    searchCompany() {
      let company_id = this.campaign.company_id;
      let company = this.companies.find(function (item) {
        return item.id == company_id;
      });
      this.fetchSelectedSites(company.slug);
    },
  },
  computed: {
    ...mapGetters("proponent", ["campaigns", "errors"]),
    ...mapGetters("company", ["companies"]),
    ...mapGetters("site", ["selected_sites"]),
    ...mapGetters("cost_center", ["cost_centers"]),

    filteredCampaigns() {
      let list = this.campaigns;
      list = this.campaigns.filter((campaign) => {
        return campaign.name
          .toLowerCase()
          .includes(this.searchName.toLowerCase());
      });
      return list;
    },
  },
  mounted() {
    this.fetchCampaigns();
    this.fetchCompanies();
    this.fetchCostCenters();
  },
};
</script>

<style scoped>
.modal {
  /* position: absolute; */
  background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}
/* .modal-content{
  margin-top:auto;
} */

.show {
  display: block;
  height: -webkit-fill-available;
}
</style>