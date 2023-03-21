import axios from "axios";

const state = {
    sites: [],
    selected_sites: [],
    errors: {
        error: false,
        message: '',
    },
};

const getters = {
    sites: (state) => state.sites,
    selected_sites: (state) => state.selected_sites,
    site: (state) => state.site,
    site_errors: (state) => state.errors,
};

const actions = {
    async fetchSites({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/sites/all', {
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

    async fetchSelectedSites({ commit, rootGetters }, company_name) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get(`/admin/companies/company-sites/${company_name}`, {
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

    async createSite({ commit, rootGetters }, site) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.post('/admin/sites/create', site, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            commit('ERRORS', response.data);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    async updateSelectedSite({ commit, rootGetters }, site) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.patch('/admin/sites/edit', site, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            commit('ERRORS', response.data);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    async siteSearch({ commit }, search_name) {
        try {
            const response = await axios.post('/admin/sites/search', search_name);

            commit('LIST', response.data['data']);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    resetSelectedSites({ commit }) {
        commit('SELECTED_LIST', []);
    },
    resetSites({ commit }) {
        commit('LIST', []);
    },
    assignSite({ commit }, site) {
        commit('UPDATE_SITE', site);
    },
    resetSiteError({ commit }) {
        commit('ERRORS', {
            error: false,
            message: '',
        });
    }
};

const mutations = {
    ERRORS: (state, error) => {
        console.log(`errors = ${JSON.stringify(error)}`);
        (state.errors = error);
    },
    LIST: (state, list) => {
        (state.sites = list)
    },
    SELECTED_LIST: (state, list) => {
        (state.selected_sites = list)
    },
    UPDATE_SITE: (state, site) => {
        (state.site = site)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};