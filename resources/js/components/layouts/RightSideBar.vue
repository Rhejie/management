<template>
  <div class="dz-scroll active p-fixed mt-8rem" id="eventSidebar">
    <div class="card shadow-none rounded-0 bg-transparent h-auto mb-0">
      <div class="card-body text-center event-calender pb-2">
        <calendar :attributes="attrs"></calendar>
      </div>
    </div>
    <div class="card shadow-none rounded-0 bg-transparent h-auto">
      <div class="card-header border-0 pb-0">
        <h4 class="text-black">Upcoming Events</h4>
      </div>
      <div class="card-body">
        <div class="media mb-5 align-items-center event-list">
          <div class="p-3 text-center rounded mr-3 date-bx bgl-primary">
            <h2 class="mb-0 text-black">3</h2>
            <h5 class="mb-1 text-black">Wed</h5>
          </div>
          <div class="media-body px-0">
            <h6 class="mt-0 mb-3 fs-14">
              <a class="text-black" href="./events">50 OPEX Transfers</a>
            </h6>
            <ul class="fs-14 list-inline mb-2 d-flex justify-content-between">
              <li>Pending</li>
              <li>18/50</li>
            </ul>
            <div class="progress mb-0" style="height: 4px; width: 100%">
              <div
                class="progress-bar bg-warning progress-animated"
                style="width: 85%; height: 8px"
                role="progressbar"
              >
                <span class="sr-only">64% Complete</span>
              </div>
            </div>
          </div>
        </div>
        <div class="media mb-5 align-items-center event-list">
          <div class="p-3 text-center rounded mr-3 date-bx bgl-primary">
            <h2 class="mb-0 text-black">16</h2>
            <h5 class="mb-1 text-black">Tue</h5>
          </div>
          <div class="media-body px-0">
            <h6 class="mt-0 mb-3 fs-14">
              <a class="text-black" href="./events">120 CAPEX Transfers</a>
            </h6>
            <ul class="fs-14 list-inline mb-2 d-flex justify-content-between">
              <li>Pending</li>
              <li>43/150</li>
            </ul>
            <div class="progress mb-0" style="height: 4px; width: 100%">
              <div
                class="progress-bar bg-warning progress-animated"
                style="width: 50%; height: 8px"
                role="progressbar"
              >
                <span class="sr-only">72% Complete</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Calendar from "v-calendar/lib/components/calendar.umd";

export default {
  components: {
    calendar: Calendar,
  },
  data: () => ({
    attrs: [
      {
        key: "today",
        highlight: true,
        dates: new Date(),
      },
    ],
  }),
  computed: {},
  methods: {},
};
</script>

<style scoped>
.p-fixed {
  position: fixed;
}

.mt-8rem {
  right: 0;
  top: 7.5rem;
}

.fit-contents{
  height: -webkit-fill-available;
}

@media only screen and (max-width: 1400px) {
  .mt-8rem {
    top: 5rem;
  }
}
</style>