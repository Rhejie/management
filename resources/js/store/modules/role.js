import axios from "axios";
import VueCookies from 'vue-cookies'

const state = {
    roles: [],
    role: {
        id: null,
        name: '',
    },
    errors: {
        error: false,
        message: '',
    },
};

const getters = {
    roles: (state) => state.roles,
    errors: (state) => state.errors,
};

const actions = {
    async fetchRoles({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/roles/all', {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('ROLE_LIST', list);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    async createRole({ commit, rootGetters }, role) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.post('/admin/roles/create', role, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            commit('ERRORS', response.data);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    async updateRole({ commit, rootGetters }, role) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.patch('/admin/roles/edit', role, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            commit('ERRORS', response.data);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },
};

const mutations = {
    ERRORS: (state, error) => {
        console.log(`errors = ${error}`);
        (state.errors = error);
    },
    ROLE_LIST: (state, list) => {
        (state.roles = list)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};