import axios from "axios";

const state = {
    companies: [],
    company: {
        id: null,
        name: '',
    },
    errors: {},
};

const getters = {
    companies: (state) => state.companies,
    errors: (state) => state.errors,
};

const actions = {
    async fetchCompanies({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/companies/all', {
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
        (state.companies = list)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};