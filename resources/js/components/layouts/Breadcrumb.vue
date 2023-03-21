<template>
  <div class="page-titles">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0)">{{ current }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          {{ $route.name }}
        </li>
      </ol>
    </nav>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    computed: {
        ...mapGetters("navigation", ["current"]),
    }
}
</script>