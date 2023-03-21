import axios from "axios";

const state = {
    permissions: [],
    errors: {},
};

const getters = {
    permissions: (state) => state.permissions,
    errors: (state) => state.errors,
};

const actions = {
    async fetchPermissions({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/permissions/all', {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('LIST', list);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    resetErrors({ commit }) {
        commit('ERRORS', null);
    }
};

const mutations = {
    ERRORS: (state, error) => {
        console.log(`errors = ${error}`);
        (state.errors = error);
    },
    LIST: (state, list) => {
        (state.permissions = list)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};