<template>
  <nav id="sidebar">
    <div class="nav-header white-logo p-fixed">
      <p class="brand-logo c-pointer" @click="homeURL">
        <img src="/images/inspiro-logo.png" alt="Inspiro" />
      </p>
    </div>

    <div class="deznav pt-3 p-fixed">
      <div class="deznav-scroll">
        <accordion>
          <accordion-item v-for="(nav, index) in navs" :key="index">
            <!-- This slot will handle the title/header of the accordion and is the part you click on -->
            <template slot="accordion-trigger">
              <!-- <div class="d-flex" :class="link.isActive ? ' rounded-edge active': ''"> -->
              <div
                v-if="nav.url"
                class="d-flex"
                :class="nav.isActive ? ' nav-active' : ''"
                @click="pushURL(nav, nav.url)"
              >
                <i
                  :class="!nav.isActive ? nav.icon : nav.icon + ' active'"
                  class="icon mr-2"
                ></i>
                <span class="icon-label">{{ nav.label }}</span>
              </div>
              <div
                v-else
                class="d-flex"
                :class="nav.isActive ? ' nav-active' : ''"
              >
                <i
                  :class="!nav.isActive ? nav.icon : nav.icon + ' active'"
                  class="icon mr-2"
                ></i>
                <span class="icon-label">{{ nav.label }}</span>
              </div>
            </template>
            <!-- This slot will handle all the content that is passed to the accordion -->
            <template slot="accordion-content">
              <li class="ml-5" v-for="(content, i) in nav.contents" :key="i">
                <p @click="pushURL(nav, content.link)">{{ content.text }}</p>
              </li>
            </template>
          </accordion-item>
        </accordion>
      </div>
    </div>
  </nav>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import Accordion from "./Accordion.vue";
import AccordionItem from "./AccordionItem.vue";

export default {
  components: {
    Accordion,
    AccordionItem,
  },
  data: () => ({
    isActive: false,
    isPanelOpen: true,
  }),
  computed: {
    ...mapGetters("navigation", ["navs"]),
  },
  methods: {
    toggle() {
      this.isActive = !this.isActive;
    },
    closeSidebarPanel() {
      this.toggle();
    },
    ...mapActions("navigation", ["urlPush"]),
    pushURL(nav, url) {
      this.urlPush(nav);
      if (this.$route.fullPath != url) {
        this.$router.push({ path: url });
      }
    },
    homeURL() {
      let nav = {
        label: "Dashboard",
        icon: "bi bi-house-fill",
        isActive: true,
        url: "/home",
      };
      this.pushURL(nav, nav.url);
    },
  },
};
</script>

<style scoped>
.p-fixed{
  position: fixed;
}

.icon {
  height: 3.5rem;
  width: 3.5rem;
  text-align: center;
  background-color: transparent;
  color: rgba(255, 255, 255, 0.7);
  line-height: 3.5rem;
  border-radius: 50%;
  font-size: 1.35rem;
}

.icon.active {
  background-color: rgb(255, 255, 255);
  color: #7386d5;
}

.nav-active {
  border-radius: 2rem;
  background: rgba(255, 255, 255, 0.2) !important;
}

.icon-label {
  line-height: 3.5rem;
  font-size: 1rem;
}

.rounded-edge.active {
  background: rgba(255, 255, 255, 0.2) !important;
  border: 1px solid;
  border-radius: 2.25rem;
}

.nav-header {
  width: 20rem;
}

.nav-header .brand-logo,
.deznav {
  background-color: #76187e;
}

.nav-header .brand-logo {
  background-color: #ffffff;
}

.deznav {
  width: 20rem;
}

#sidebar {
  min-width: 20rem;
  max-width: 20rem;
  background: #7386d5;
  color: #fff;
  transition: all 0.3s;
}

#sidebar.active {
  margin-left: -20rem;
}

#sidebar .sidebar-header {
  padding: 20px;
  background: #6d7fcc;
}

#sidebar ul.components {
  padding: 20px 0;
  border-bottom: 1px solid #47748b;
}

#sidebar ul p {
  color: #fff;
  padding: 10px;
}

#sidebar ul li p {
  padding: 0;
  font-size: 1em;
  display: block;
  color: #ffffff;
}

#sidebar ul li p:hover {
  color: #ffffff;
  text-decoration: underline;
  background: rgba(255, 255, 255, 0);
}

#sidebar ul li.active > p,
a[aria-expanded="true"] {
  color: #fff;
  background: #6d7fcc;
}
</style>