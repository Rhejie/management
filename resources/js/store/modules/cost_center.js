import axios from "axios";

const state = {
    costcenters: [],
    selected_costcenters: [],
    cost_center: {
        id: null,
        name: '',
    },
    errors: {},
};

const getters = {
    cost_centers: (state) => state.costcenters,
    selected_costcenters: (state) => state.selected_costcenters,
    errors: (state) => state.errors,
};

const actions = {
    async fetchCostCenters({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/cost-centers/all', {
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

    async fetchSelectedCostCenters({ commit, rootGetters }, slug) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get(`/admin/sites/cost-centers/${slug}`, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('SELECTED_LIST', list);
        } catch (error) {
            commit('ERRORS', error);
        }
    },
    resetSelectedCostCenters({ commit }){
        commit('SELECTED_LIST', []);
    },
};

const mutations = {
    ERRORS: (state, error) => {
        console.log(`errors = ${error}`);
        (state.errors = error);
    },
    LIST: (state, list) => {
        (state.costcenters = list)
    },
    SELECTED_LIST: (state, list) => {
        (state.selected_costcenters = list)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};