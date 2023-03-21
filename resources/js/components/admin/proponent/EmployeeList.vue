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
        <!-- 
        <div class="col-md-3">
          <button
            type="button"
            id="add"
            class="btn btn-rounded btn-primary float-end"
            @click.prevent="isBulk = true"
          >
            <span class="btn-icon-left text-info">
              <i class="bi bi-plus"></i>
            </span>
            Upload
          </button>
        </div>
         -->
      </div>
      <table class="table table-bordered">
        <thead>
          <th v-for="head in headers" :key="head">{{ head }}</th>
        </thead>
        <tbody>
          <tr v-if="filteredEmployees.length < 1 && searchName == ''">
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
          <tr v-else v-for="employee in filteredEmployees" :key="employee.id">
            <td>{{ employee.name }}</td>
            <td>{{ employee.employee_number }}</td>
            <td>{{ employee.email }}</td>
            <td>{{ employee.campaign.name }}</td>
            <td>
              <button
                @click.prevent="selectEmployee(employee)"
                type="button"
                class="btn btn-primary shadow btn-xs sharp mr-1"
              >
                <i class="bi bi-pencil-fill"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div
        :class="isBulk ? 'show' : ''"
        class="modal fade"
        id="exampleModalCenter"
        tabindex="-1"
        aria-labelledby="exampleModalCenterTitle"
        aria-modal="true"
        role="dialog"
      >
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title pt-3 pb-3">Bulk Employee Upload</h5>
            </div>
            <div class="modal-body">
              <div class="mb-3 row">
                <div class="col-sm">
                  <input
                    type="file"
                    class="form-control"
                    @change="fileChanged"
                    ref="file"
                  />
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                @click="isBulk = false"
              >
                Close
              </button>
              <button
                type="button"
                class="btn btn-primary"
                @click.prevent="updloadBulk"
              >
                Save changes
              </button>
            </div>
          </div>
        </div>
      </div>

      <div
        :class="show ? 'show' : ''"
        class="modal fade"
        id="exampleModalCenter"
        tabindex="-1"
        aria-labelledby="exampleModalCenterTitle"
        aria-modal="true"
        role="dialog"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content mt-3">
            <div class="modal-header">
              <h5 class="modal-title pt-3 pb-3">Employee Update</h5>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col">
                  <div class="mb-3 row">
                    <label class="col-form-label mt-2">Company</label>
                    <div class="col-sm">
                      <select
                        v-model="employee.company_id"
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
                        v-model="employee.site_id"
                        class="form-control form-select form-select-md"
                        required
                        @change="siteChange"
                      >
                        <option
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
                    </div>
                  </div>
                </div>
              </div>

              <div class="mb-3 row">
                <label class="col-form-label mt-2">Campaign</label>
                <div class="col-sm">
                  <select
                    v-model="employee.campaign_id"
                    class="form-control form-select form-select-md"
                    required
                  >
                    <option
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
                          v-for="(error, index) in errors.message.campaign_id"
                          :key="index"
                        >
                          <i class="text-danger">{{ error }}</i>
                        </li>
                      </ul>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="mb-3 row">
                    <label class="col-form-label mt-2">Name</label>
                    <div class="col-sm">
                      <input
                        v-model="employee.name"
                        type="text"
                        class="form-control"
                        required
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
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="mb-3 row">
                    <label class="col-form-label mt-2">Email</label>
                    <div class="col-sm">
                      <input
                        v-model="employee.email"
                        type="text"
                        class="form-control"
                        required
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
  components: {},
  data: () => ({
    searchName: "",
    headers: ["Name", "Employee Number", "Email", "Campaign", "Actions"],
    show: false,
    isBulk: false,
    employee: {
      id: null,
      name: "",
      proponent_number: "",
      site_id: null,
      company_id: null,
      campaign_id: null,
      email: "",
    },
    file: null,
  }),
  methods: {
    ...mapActions("proponent", [
      "fetchEmployees",
      "updateEmployee",
      "fetchSelectedCampaigns",
      "resetError",
      "resetCampaigns",
      "bulkEmployeeUpload",
    ]),
    ...mapActions("company", ["fetchCompanies"]),
    ...mapActions("site", ["fetchSelectedSites"]),
    toggleOpen() {
      this.show = !this.show;
    },
    selectEmployee(employee) {
      this.employee = {
        id: employee.id,
        name: employee.name,
        proponent_number: employee.employee_number,
        site_id: employee.campaign.site_id,
        company_id: employee.company.id,
        campaign_id: employee.campaign_id,
        email: employee.email,
      };

      this.resetError();
      let company = this.companies.find((item) => {
        return item.id == this.employee.company_id;
      });

      this.fetchSelectedSites(company.slug).then(() => {
        let site = this.selected_sites.find((item) => {
          return item.id == this.employee.site_id;
        });

        this.fetchSelectedCampaigns(site.id);
      });

      this.toggleOpen();
    },
    submitForm() {
      this.updateEmployee(this.employee).then(() => {
        if (!this.errors.error) {
          this.fetchEmployees();
          this.toggleOpen();
        }
      });
    },
    companyChange() {
      let company_id = this.employee.company_id;
      let company = this.companies.find(function (item) {
        return item.id == company_id;
      });

      this.employee.site_id = null;
      this.employee.campaign_id = null;
      this.fetchSelectedSites(company.slug);
      this.resetCampaigns();
    },
    siteChange() {
      if (this.employee.site_id != null) {
        let site_id = this.employee.site_id;
        let site = this.selected_sites.find(function (item) {
          return item.id == site_id;
        });
        console.log(`site selected ${JSON.stringify(site)}`);
        this.fetchSelectedCampaigns(site.id);
      }
      this.employee.campaign_id = null;
    },
    fileChanged(event) {
      this.file = event.target.files[0];
    },
    updloadBulk() {
      let input_file = new FormData();
      input_file.append("file", this.file);
      this.bulkEmployeeUpload(input_file).then(() => {
        this.isBulk = false;
      });
    },
  },
  computed: {
    ...mapGetters("proponent", ["employees", "campaigns", "errors"]),
    ...mapGetters("company", ["companies"]),
    ...mapGetters("site", ["selected_sites"]),
    filteredEmployees() {
      let employeeList = this.employees;
      employeeList = this.employees.filter((employee) => {
        return employee.name
          .toLowerCase()
          .includes(this.searchName.toLowerCase());
      });
      return employeeList;
    },
  },
  mounted() {
    this.fetchEmployees();
    this.fetchCompanies();
  },
};
</script>

<style scoped>
.modal {
  /* position: absolute; */
  background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}
/* .modal-content {
  margin-top: auto;
} */

.show {
  display: block;
  height: -webkit-fill-available;
}
</style>