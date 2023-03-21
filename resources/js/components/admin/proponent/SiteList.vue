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
          <tr v-if="filteredSites.length < 1 && searchName == ''">
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
          <tr v-else v-for="site in filteredSites" :key="site.id">
            <td>{{ site.name }}</td>
            <td>{{ site.company.name }}</td>
            <td>
              <button
                @click.prevent="selectSite(site)"
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
              <h5 class="modal-title">Site Update</h5>
            </div>
            <div class="modal-body">
              <div class="mb-3 row">
                <label class="col-form-label mt-2">Company</label>
                <div class="col-sm">
                  <select
                    v-model="site.company_id"
                    class="form-control form-select form-select-md"
                    required
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

              <div class="mb-3 row">
                <label class="col-form-label mt-2">Name</label>
                <div class="col-sm">
                  <input
                    v-model="site.name"
                    type="text"
                    class="form-control"
                    required
                  />
                  <div class="feedback" v-if="site_errors.error">
                    <i v-for="error in site_errors.message.name" :key="error">{{
                      error
                    }}</i>
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
    headers: ["Name", "Company", "Actions"],
    site: {
        id: null,
        company_id: null,
        name: '',
        sap_code: null,
    },
  }),
  methods: {
    ...mapActions("site", ["fetchSites", "assignSite", "updateSelectedSite"]),
    ...mapActions("company", ["fetchCompanies"]),
    toggleOpen() {
      this.show = !this.show;
    },
    selectSite(site) {
      this.site.id = site.id;
      this.site.name = site.name;
      this.site.company_id = site.company_id;

      this.toggleOpen();
      this.assignSite(this.site);
    },
    submitForm() {
      this.updateSelectedSite(this.site).then(() => {
        if (!this.site_errors.error) {
          this.fetchSites();
          this.toggleOpen();
        }
      });
    },
  },
  computed: {
    ...mapGetters("site", ["sites", "site_errors"]),
    ...mapGetters("company", ["companies"]),
    filteredSites() {
      let list = this.sites;
      list = this.sites.filter((item) => {
        return item.name.toLowerCase().includes(this.searchName.toLowerCase());
      });
      return list;
    },
  },
  mounted() {
    this.fetchSites();
    this.fetchCompanies();
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