import axios from "axios";
import VueCookies from 'vue-cookies'
import auth from "./auth";

const token = auth.state.token;
axios.defaults.headers.common = { 'Authorization': `Bearer ${token}` };

const state = {
    errors: {},
    quantity_allocations: [],
    assets: [],
    asset_type: null,
    asset: {},
};

const getters = {
    errors: (state) => state.errors,
    quantity_allocations: (state) => state.quantity_allocations,
    assets: (state) => state.assets,
    asset_type: (state) => state.asset_type,
    asset: (state) => state.asset,
};

const actions = {
    async fetchInventoryAssets({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/inventory/all', {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data;
            commit('LIST_ASSETS', list);
        } catch (error) {
            commit('ERRORS', error);
        }
    },
    async saveAllocation({ commit }, data) {
        try {
            const response = await axios.post('/admin/inventory/allocation/save', data)
            commit('ERRORS', []);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for (const f in eResp.message)
                oError[f] = eResp.message[f][0];

            commit('ERRORS', oError);
        }
    },
    async fetchQuantityAllocation({ commit, rootGetters }, data) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/inventory/allocation/get/'+data.asset_id, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('LIST', list);
        } catch (error) {
            commit('ERRORS', error);
        }
    },
    resetList({commit}){
        commit('LIST', []);
    },
    setAssetType({commit}, type){
        commit('SET_ASSET_TYPE', type)
    },
    setAsset({commit}, asset){
        commit('SET_ASSET', asset)
    }
};

const mutations = {
    ERRORS: (state, error) => (state.errors = error),
    LIST: (state, list) => {
        (state.quantity_allocations = list)
    },
    LIST_ASSETS: (state, list) => {
        (state.assets = list)
    },
    SET_ASSET_TYPE: (state,type) => (state.asset_type = type),
    SET_ASSET: (state,asset) => (state.asset = asset),
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};