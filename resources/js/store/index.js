import Vue from "vue";
import Vuex from "vuex";
import auth from "./modules/auth"
import role from "./modules/role"
import user from "./modules/user"
import brands from "./modules/brands"
import createPersistedState from "vuex-persistedstate"
import navigation from "./modules/navigation"
import company from "./modules/company"
import asset_class from "./modules/asset_class"
import cost_center from "./modules/cost_center"
import purchase_order from "./modules/purchase_order"
import physical_asset from "./modules/physical_asset"
import software_asset from "./modules/software_asset"
import proponent from "./modules/proponent"
import site from "./modules/site"
import asset_subclass from "./modules/asset_subclass"
import permission from "./modules/permission";
import segments from "./modules/segments"
import brand_model from "./modules/brand_model"
import transaction from "./modules/transaction"
import inventory from "./modules/inventory"
import asset_summary from "./modules/asset_summary"
import VueCookies from 'vue-cookies'

Vue.use(Vuex)

export default new Vuex.Store({
    plugins: [
        createPersistedState({
            paths: ['auth', 'navigation', 'purchase_order'],
            storage: {
                getItem: key => $cookies.get(key),
                setItem: (key, value) => $cookies.set(key, value, { expires: 1, secure: true }),
                removeItem: key => $cookies.remove(key)
            }
        }),
    ],
    modules: {
        navigation,
        auth,
        role,
        permission,
        user,
        company,
        site,
        asset_class,
        cost_center,
        purchase_order,
        brands,
        physical_asset,
        proponent,
        software_asset,
        asset_subclass,
        segments,
        brand_model,
        transaction,
        inventory,
        asset_summary,
    }
});