import Vue from 'vue'
import VueRouter from 'vue-router';
import store from '../store';

import Login from '../components/auth/Login';
import Dashboard from '../components/views/Dashboard'
import Register from '../components/auth/Register'
import UserUpdate from '../components/admin/users/UserUpdate'
import AssetAdd from '../components/admin/inventory/AssetAdd'
import ProponentForm from '../components/admin/proponent/ProponentForm'
// import PasswordChange from '../components/auth/PasswordChange'
import ProponentTabs from '../components/admin/proponent/ProponentTabs'
import SoftwareLicenses from '../components/admin/inventory/SoftwareLicenses'
import PhysicalAssets from '../components/admin/inventory/PhysicalAssets'
import AssetSummaryUpdate from '../components/admin/inventory/AssetSummaryUpdate'
// import Brands from '../components/admin/maintenance/Brands'
// import AssetClasses from '../components/admin/maintenance/AssetClasses'
// import AssetSubClasses from '../components/admin/maintenance/AssetSubClasses'
// import Segments from '../components/admin/maintenance/Segments'
// import RolesForm from '../components/admin/maintenance/RolesForm'
import RoleList from '../components/admin/maintenance/RoleList'
// import BrandModels from '../components/admin/maintenance/BrandModels'
import MaintenanceTabs from '../components/admin/maintenance/MaintenanceTabs'
import NewTransaction from '../components/transactions/NewTransaction'
import QuantityAllocation from '../components/admin/inventory/QuantityAllocation';
import AssetInquiry from '../components/admin/inventory/AssetInquiry';
import AssetRegistry from '../components/admin/inventory/AssetRegistry';
import PurchaseOrder from '../components/admin/inventory/PurchaseOrder';
import AssetsTabs from '../components/admin/inventory/AssetsTabs';
import AssetView from '../components/admin/inventory/AssetView'
import AssetViewPO from '../components/admin/inventory/AssetViewPO'
Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      title: 'Login',
      auth: false,
    }
  },
  {
    path: '/home',
    name: 'home',
    component: Dashboard,
    meta: {
      title: 'Home',
      auth: true
    },
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: {
      title: 'Register',
      auth: true,
      admin: true,
    },
  },
  {
    path: '/user-list',
    name: 'User List',
    component: UserUpdate,
    meta: {
      title: 'User List',
      auth: true,
      admin: true,
    },
  },
  {
    path: '/add-asset',
    name: 'Add Asset',
    component: AssetAdd,
    meta: {
      title: 'Add Asset',
      auth: true,
      admin: true,
    },
  },
  {
    path: '/asset-user-add',
    name: 'Add Asset User',
    component: ProponentForm,
    meta: {
      title: 'Add Asset User',
      auth: true,
      admin: true,
    },
  },
  {
    path: '/proponent-list',
    name: 'Asset Users',
    component: ProponentTabs,
    meta: {
      title: 'Asset Users',
      auth: true,
      admin: true,
    },
  },
//   {
//     path: '/software-licenses',
//     name: 'Software Licenses',
//     component: SoftwareLicenses,
//     meta: {
//       title: 'Software Licenses',
//       auth: true,
//       admin: true,
//     },
//   },
//   {
//     path: '/hardware-assets',
//     name: 'Physical Assets',
//     component: PhysicalAssets,
//     meta: {
//       title: 'Physical Assets',
//       auth: true,
//       admin: true,
//     },
//   },
  {
    path: '/update-asset',
    name: 'Update Asset',
    component: AssetSummaryUpdate,
    meta: {
      title: 'Update Asset',
      auth: true,
      admin: true,
    },
  },
  {
    path: '/master-list',
    name: 'Master List',
    component: MaintenanceTabs,
    meta: {
      title: 'Master List',
      auth: true,
      admin: true,
    },
  },
  {
    path: '/transactions/assign',
    name: 'Assign',
    component: NewTransaction,
    meta: {
      title: 'Assign',
      auth: true,
      admin: true,
    },
  },
  // {
  //   path: '/system-access/create',
  //   name: 'Create System Access',
  //   component: RolesForm,
  //   meta: {
  //     title: 'Create System Access',
  //     auth: true,
  //     admin: true,
  //   },
  // },
  {
    path: '/system-access',
    name: 'System Access',
    component: RoleList,
    meta: {
      title: 'System Access',
      auth: true,
      admin: true,
    },
  },
  // {
  //   path: '/quantity-allocation',
  //   name: 'Entity Quantity Allocation',
  //   component: QuantityAllocation,
  //   meta: {
  //     title: 'Entity Quantity Allocation',
  //     auth: true,
  //     admin: true,
  //   },
  // },
//   {
//     path: '/asset-inquiry',
//     name: 'Asset Inquiry',
//     component: AssetInquiry,
//     meta: {
//       title: 'Asset Inquiry',
//       auth: true,
//       admin: true,
//     },
  // },
  {
    path: '/asset-list',
    name: 'Asset List',
    component: AssetsTabs,
    meta: {
      title: 'Asset Registry',
      auth: true,
      admin: true,
    },
  },
  {
    path: '/purchase-order',
    name: 'Purchase Order',
    component: PurchaseOrder,
    meta: {
      title: 'Purchase Order',
      auth: true,
      admin: true,
    },
  },
  {
    path: '/asset-view',
    name: 'Asset View',
    component: AssetView,
    meta: {
      title: 'Asset View',
      auth: true,
      admin: true,
    },
  },
  {
    path: '/asset-view-po',
    name: 'Asset View',
    component: AssetViewPO,
    meta: {
      title: 'Asset View',
      auth: true,
      admin: true,
    },
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  }
});

router.beforeEach(function (to, from, next) {
  // Use the page's router title to name the page
  if (to.meta && to.meta.title) {
    document.title = to.meta.title
  }

  store.dispatch('auth/checkAuthentication');
  const token = store.getters['auth/getToken'];
  const position = store.getters['auth/position'];

  if (to.meta && to.meta.auth !== undefined) {
    // if the page requires auth
    if (to.meta.auth) {
      //check if token exists
      if (!token) {
        router.push({ name: 'login' });
        return;
      }
      if (to.meta.admin && position != 'admin') {
        console.log(position)
        router.push({ name: 'home' });
        return;
      }
      next();
      return;
    }
  } else if (to.meta && to.meta.auth === undefined) {
    next();
    return;
  }

  if (token) {
    router.push({ name: 'home' });
    return;
  }

  next();
  return;
});

export default router
