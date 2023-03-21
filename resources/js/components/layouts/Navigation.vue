<template>
  <div>
    <div class="wrapper">
      <!-- Sidebar  -->
      <Sidebar v-if="isAuthenticated" />
      <Header v-if="isAuthenticated"></Header>

      <!-- Page Content  -->
      <div id="content" :class="isAuthenticated ? 'auth-content' : ''">
        <!-- <Header v-if="isAuthenticated"></Header> -->
        <div :class="isAuthenticated ? 'd-flex justify-content-end' : ''">
          <router-view
            class="container-fluid"
            :class="!isAuthenticated ? 'pl-3' : ''"
          ></router-view>
          <!-- <right-side-bar v-if="isAuthenticated" class="bg-white fit-contents"/> -->
        </div>
      </div>

      <!-- <right-side-bar v-if="isAuthenticated" class="bg-white fit-contents" /> -->
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Sidebar from "./Sidebar.vue.vue";
import Header from "./Header.vue";
import RightSideBar from "./RightSideBar.vue";
export default {
  components: {
    Header,
    Sidebar,
    RightSideBar,
  },
  data: () => ({
    toggled: false,
  }),
  methods: {},
  computed: {
    ...mapGetters("auth", ["isAuthenticated"]),
  },
};
</script>

<style scoped>
.navbar {
  padding: 15px 10px;
  background: #fff;
  border: none;
  border-radius: 0;
  margin-bottom: 40px;
  box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}

.navbar-btn {
  box-shadow: none;
  outline: none !important;
  border: none;
}

.line {
  width: 100%;
  height: 1px;
  border-bottom: 1px dashed #ddd;
  margin: 40px 0;
}

/* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

.wrapper {
  display: flex;
  width: 100%;
  align-items: stretch;
}

a[data-toggle="collapse"] {
  position: relative;
}

.dropdown-toggle::after {
  display: block;
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
}

ul ul a {
  font-size: 0.9em !important;
  padding-left: 30px !important;
  background: #6d7fcc;
}

ul.CTAs {
  padding: 20px;
}

ul.CTAs a {
  text-align: center;
  font-size: 0.9em !important;
  display: block;
  border-radius: 5px;
  margin-bottom: 5px;
}

a.download {
  background: #fff;
  color: #7386d5;
}

a.article,
a.article:hover {
  background: #6d7fcc !important;
  color: #fff !important;
}

/* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */

#content {
  width: 100%;
  min-height: 100vh;
  transition: all 0.3s;
  padding: 0;
}

.auth-content{
  /* margin-right: 20rem; */
  margin-top: 7.5rem;
  z-index: 0;
}

.fit-contents {
  min-width: fit-content;
}

/* ---------------------------------------------------
    MEDIAQUERIES
----------------------------------------------------- */

/* @media (max-width: 768px) {
  #sidebar {
    margin-left: -250px;
  }
  #sidebar.active {
    margin-left: 0;
  }
  #sidebarCollapse span {
    display: none;
  }
} */
</style>