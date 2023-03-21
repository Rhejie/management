<template>
  <div class="mt-5 mx-4">
    <!-- <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="px-5 py-5">
              <canvas id="chart" width="500rem"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="px-5 py-5">
              <canvas id="transactions" width="500rem"></canvas>
            </div>
          </div>
        </div>
      </div>
      
    </div> -->
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  components: {},
  data: () => ({
    chart: {
      type: "line",
      data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [
          {
            label: "# of Votes",
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
              "rgba(255, 99, 132, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(255, 206, 86, 0.2)",
              "rgba(75, 192, 192, 0.2)",
              "rgba(153, 102, 255, 0.2)",
              "rgba(255, 159, 64, 0.2)",
            ],
            borderColor: [
              "rgba(255, 99, 132, 1)",
              "rgba(54, 162, 235, 1)",
              "rgba(255, 206, 86, 1)",
              "rgba(75, 192, 192, 1)",
              "rgba(153, 102, 255, 1)",
              "rgba(255, 159, 64, 1)",
            ],
            borderWidth: 2,
          },
        ],
      },
      options: {
        legend: { display: false },
        title: {
          display: true,
          text: "Sample Results",
        },
        scales: {
          xAxes: [{ stacked: true }],
          yAxes: [{ stacked: true }],
        },
      },
    },
    transactions: {
      type: "bar",
      data: {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
        ],
        datasets: [
          {
            label: "Transactions",
            data: [65, 59, 80, 81, 56, 55, 40],
            backgroundColor: [
              "rgba(255, 99, 132, 0.2)",
              "rgba(255, 159, 64, 0.2)",
              "rgba(255, 205, 86, 0.2)",
              "rgba(75, 192, 192, 0.2)",
              "rgba(54, 162, 235, 0.2)",
              "rgba(153, 102, 255, 0.2)",
              "rgba(201, 203, 207, 0.2)",
            ],
            borderColor: [
              "rgb(255, 99, 132)",
              "rgb(255, 159, 64)",
              "rgb(255, 205, 86)",
              "rgb(75, 192, 192)",
              "rgb(54, 162, 235)",
              "rgb(153, 102, 255)",
              "rgb(201, 203, 207)",
            ],
            borderWidth: 1,
          },
        ],
      },
    },
  }),
  methods: {
    showChart() {
      let ctx = document.getElementById("chart").getContext("2d");
      let chart = new Chart(ctx, this.chart);

      let transactions_ctx = document
        .getElementById("transactions")
        .getContext("2d");
      let transactions_chart = new Chart(transactions_ctx, this.transactions);
    },
  },
  mounted() {
    // this.showChart();
  },
};
</script>
