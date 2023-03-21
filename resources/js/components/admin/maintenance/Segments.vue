<template>
  <div>
    <div class="container-fluid">
      <div class="row justify-content-end form-group mt-2">
        <div class="col-auto col-md">
          <input
            type="text"
            class="form-control"
            placeholder="Search segment names"
            v-model="searchName"
          />
        </div>
        <div class="col">
          <button
            type="button"
            id="add"
            class="btn btn-rounded btn-primary float-end"
            @click.prevent="toggleOpen"
          >
            <span class="btn-icon-left text-info">
              <i class="bi bi-plus"></i>
            </span>
            Create
          </button>
        </div>
      </div>
      <div class="row">
        <table class="table table-hover">
          <thead>
            <tr>
                <th v-for="head in headers" :key="head">{{ head }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredSegments.length == 0">
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
            <tr v-for="segment in filteredSegments" :key="segment.id">
              <td>{{ segment.name }}</td>
              <td>
                <div class="d-flex">
                    <button
                      @click.prevent="update(segment)"
                      type="button"
                      class="btn btn-primary shadow btn-xs sharp mr-1"
                    >
                      <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button
                      @click="setId(segment.id)"
                      type="button"
                      class="btn btn-danger shadow btn-xs sharp mr-1"
                    >
                      <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- Modal CREATE -->
        <div
          class="modal fade show"
          id="segmentForm"
          data-bs-backdrop="static"
          tabindex="-1"
          aria-labelledby="segmentForm"
          aria-hidden="true"
          v-if="show"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Create new segment</h5>
                <button
                  @click.prevent="onClose"
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="mb-3">
                    <label for="segment-name" class="col-form-label"
                      >Name:</label
                    >
                    <input
                      id="name"
                      type="text"
                      v-model="segment.name"
                      class="form-control"
                      :class="{ 'is-invalid': errors.name }"
                      required
                    />
                    <div v-if="errors.name" class="invalid-feedback">
                      {{ errors.name }}
                    </div>
                  </div>
                  <!-- <div class="mb-3">
                                                <label for="company-name" class="col-form-label"
                                                    >Company Name:</label
                                                >
                                                <input
                                                    id="company_name"
                                                    type="text"
                                                    v-model="segment.company_name"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid': errors.company_name,
                                                    }"
                                                    required
                                                />
                                                <div
                                                    v-if="errors.company_name"
                                                    class="invalid-feedback"
                                                >
                                                    {{ errors.company_name }}
                                                </div>
                                            </div> -->
                </form>
              </div>
              <div class="modal-footer">
                <button
                  @click.prevent="onClose"
                  type="button"
                  class="btn btn-dark"
                  data-bs-dismiss="modal"
                >
                  Cancel
                </button>
                <button
                  @click.prevent="onSubmit"
                  type="button"
                  class="btn btn-primary"
                >
                  {{ action }}
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal DELETE -->
        <div
          class="modal fade show"
          tabindex="-1"
          id="delete"
          data-bs-backdrop="static"
          aria-labelledby="delete"
          aria-hidden="true"
          v-if="showDelete"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  @click.prevent="toggleDelete()"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to delete?</p>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-dark"
                  @click.prevent="toggleDelete()"
                >
                  Cancel
                </button>
                <button
                  @click.prevent="onDelete()"
                  type="button"
                  class="btn btn-danger"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Modal, Tooltip } from "bootstrap";
import { mapActions, mapGetters, mapState } from "vuex";
export default {
  components: {},
  data: () => ({
    searchName: "",
    headers: ['Segment Name', 'Action'],
    segment: {
      id: null,
      name: "",
      // company_name: "",
    },
    action: "Create",
    show: false,
    showDelete: false,
    // errors: {}
  }),
  methods: {
    ...mapActions("segments", [
      "fetchSegments",
      "createSegment",
      "updateSegment",
      "deleteSegment",
      "clearErrors",
      "resetSegment",
      "setSegment",
    ]),
    async onSubmit() {
      this.clearErrors();
      if (this.action === "Create") await this.createSegment(this.segment);
      else await this.updateSegment(this.segment);

      if (Object.keys(this.errors).length) return;

      // modal.hide()
      this.toggleOpen();
      this.reset();
    },
    toggleOpen() {
      this.show = !this.show;
    },
    toggleDelete() {
      this.showDelete = !this.showDelete;
    },
    onClose() {
      this.toggleOpen();
      this.clearErrors();
      this.reset();
    },
    update(segment) {
      this.action = "Update";
      // this.setSegment(segment)
      // let container = document.getElementById("segmentForm");
      // let modal = new Modal(container);

      this.segment.name = segment.name;
      // this.segment.company_name = segment.company_name
      this.segment.id = segment.id;
      // modal.show();
      this.toggleOpen();
    },
    setId(id) {
      this.segment.id = id;
      this.toggleDelete();
    },
    async onDelete() {
      let modal = Modal.getInstance(document.getElementById("delete"));
      await this.deleteSegment(this.segment);
      if (!Object.keys(this.errors).length) this.toggleDelete();
    },
    reset() {
      // this.segment = this.getSegment
      this.resetSegment();
      this.segment = this.getSegment;
      this.clearErrors();
      this.action = "Create";
      console.log("clearing data", this.segment);
    },
  },
  computed: {
    ...mapState({
      // segments: (state) => state.segments.segments,
      errors: (state) => state.segments.errors,
    }),
    ...mapGetters("segments", ["getErrors", "getSegment", "segments"]),
    filteredSegments() {
      let list = this.segments;
      list = this.segments.filter((segment) => {
        return segment.name
          .toLowerCase()
          .includes(this.searchName.toLowerCase());
      });
      return list;
    },
  },
  created() {
    this.fetchSegments();
  },
  watch: {},
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
