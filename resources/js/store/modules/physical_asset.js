import axios from "axios";

const state = {
    physical_assets: [],
    errors: {},
};

const getters = {
    physical_assets: (state) => state.physical_assets,
    errors: (state) => state.errors,
};

const actions = {
    async fetchPhysicalAssets({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/physical-assets/all', {
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
    async fetchPhysicalAssetInventory({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/brands/models/physical-asset-inventory', {
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
};

const mutations = {
    ERRORS: (state, error) => {
        console.log(`errors = ${error}`);
        (state.errors = error);
    },
    LIST: (state, list) => {
        (state.physical_assets = list)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};