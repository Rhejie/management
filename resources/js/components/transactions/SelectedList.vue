<template>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <div class="d-flex">
        <span class="mr-auto">{{ selected_proponent.type }} Name</span>
        <span>{{ selected_proponent.name }}</span>
      </div>
    </li>
    <li v-if="selected_proponent.type != 'Site'" class="list-group-item">
      <div class="d-flex">
        <span class="mr-auto">{{ selected_proponent.type }} Number</span>
        <span>{{ selected_proponent.number }}</span>
      </div>
    </li>
    <li v-if="selected_proponent.type != 'Site'" class="list-group-item">
      <div class="d-flex">
        <span class="mr-auto">{{ selected_proponent.type }} Cost Center</span>
        <span>{{ selected_proponent.cost_center }}</span>
      </div>
    </li>
    <li class="list-group-item">
      <div class="d-flex">
        <span class="mr-auto">{{ selected_proponent.type }} Company</span>
        <span>{{ selected_proponent.company }}</span>
      </div>
    </li>
  </ul>
</template>

<script>
export default {
    props: ["selected_proponent"],
    data: () => ({})
}
</script>