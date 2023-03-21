import axios from "axios";

const state = {
    transactions: [],
    errors: {
        error: false,
        message: '',
    },
};

const getters = {
    transactions: (state) => state.proponent_types,
    errors: (state) => state.errors,
};

const actions = {
    async fetchProponentTypes({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/proponents/types', {
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

    async createEmployee({ commit, rootGetters }, employee){
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.post('/admin/employees/create', employee, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            console.log(`response ${JSON.stringify(response.data)}`)
        } catch (error) {
            commit('ERRORS', error);
        }
    },

    async updateEmployee({ commit, rootGetters }, employee){
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.patch('/admin/employees/edit', employee, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            commit('ERRORS', response.data);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    resetError({commit}){
        commit('ERRORS', {
            error: false,
            message: '',
        });
    }
};

const mutations = {
    ERRORS: (state, error) => {
        (state.errors = error);
    },
    LIST: (state, list) => {
        (state.transactions = list)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};