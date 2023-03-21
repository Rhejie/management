<template>
  <div class="p-fixed mr-20rem">
    <div class="header">
      <div class="header-content">
        <nav class="navbar navbar-expand">
          <div class="collapse navbar-collapse justify-content-between">
            <div class="header-left">
              <div class="dashboard_bar">{{ current.toUpperCase() }}</div>
            </div>

            <ul class="navbar-nav header-right">
              <li class="nav-item dropdown header-profile">
                <a
                  class="nav-link"
                  href="#"
                  role="button"
                  data-toggle="dropdown"
                  @click="toggled = !toggled"
                >
                  <i class="bi bi-person-circle profile"></i>
                </a>
                <div
                  v-if="toggled"
                  class="dropdown-menu dropdown-menu-right show"
                >
                  <p class="dropdown-item ai-icon text-danger" @click="logoutUser">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="ml-2">Logout</span>
                  </p>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <!-- end -->
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Sidebar from "./Sidebar.vue.vue";
export default {
  components: {
    Sidebar,
  },
  data: () => ({
    toggled: false,
  }),
  methods: {
    ...mapActions("auth", ["logout"]),
    logoutUser() {
      this.logout().then(() => {
        this.$router.push({ name: "login" });
      });
    },
    profilePage(){
      this.$router.push({ name: 'change-password' });
    }
  },
  computed: {
    ...mapGetters("auth", ["isAuthenticated"]),
    ...mapGetters("navigation", ["current"]),
  },
};
</script>

<style scoped>
.p-fixed {
  position: fixed;
  z-index: 1;
}

.mr-20rem {
  margin: 0 0 0 20rem;
  min-width: calc(100% - 20rem);
}

i.profile {
  font-size: 2rem;
}
.header {
  padding-left: 0;
}

.header .header-content {
  height: 100%;
  /* padding-left: 0; */
  /* padding-right: 0; */
  align-items: center;
  display: block;
}

.header-right .header-profile .dropdown-menu {
  margin-top: -0.8em;
  padding: 0;
}

.dropdown-item.ai-icon:hover {
  cursor: pointer;
}
</style>