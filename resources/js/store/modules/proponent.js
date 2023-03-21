import axios from "axios";

const state = {
    proponent_types: [],
    ranks: [],
    employees: [],
    campaigns: [],
    sites: [],
    errors: {
        error: false,
        message: '',
    },
};

const getters = {
    proponent_types: (state) => state.proponent_types,
    ranks: (state) => state.ranks,
    employees: (state) => state.employees,
    campaigns: (state) => state.campaigns,
    sites_as_proponent: (state) => state.sites,
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
            commit('ERRORS', error.response.data);
        }
    },

    //full details
    async fetchEmployees({ commit, rootGetters }){
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/employees/all', {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('EMPLOYEE_LIST', list);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    //names and details
    async fetchEmployeeList({ commit, rootGetters }){
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/employees/details', {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('EMPLOYEE_LIST', list);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    async fetchCampaigns({ commit, rootGetters }){
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/campaigns/all', {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('CAMPAIGN_LIST', list);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    async fetchSelectedCampaigns({ commit, rootGetters }, site_name){
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get(`/admin/sites/site-campaigns/${site_name}`, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('CAMPAIGN_LIST', list);
        } catch (error) {
            commit('ERRORS', error);
        }
    },

    resetCampaigns({commit}){
        commit('CAMPAIGN_LIST', []);
    },

    resetEmployees({commit}){
        commit('EMPLOYEE_LIST', []);
    },

    async createCampaign({ commit, rootGetters }, campaign){
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.post('/admin/campaigns/create', campaign, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            console.log(`response ${JSON.stringify(response.data)}`)
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    async updateCampaign({ commit, rootGetters }, campaign){
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.patch('/admin/campaigns/edit', campaign, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            commit('ERRORS', response.data);
        } catch (error) {
            commit('ERRORS', error.response.data);
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
            commit('ERRORS', error.response.data);
        }
    },

    async bulkEmployeeUpload({ commit, rootGetters }, input_file){
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.post('/admin/employees/bulk-upload', input_file, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            console.log(`response ${JSON.stringify(response.data)}`)
        } catch (error) {
            commit('ERRORS', error.response.data);
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

    async employeeSearch({ commit }, search_name) {
        try {
            const response = await axios.post('/admin/employees/search', search_name);

            commit('EMPLOYEE_LIST', response.data['data']);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },

    async campaignSearch({ commit }, search_name) {
        try {
            const response = await axios.post('/admin/campaigns/search', search_name);

            commit('CAMPAIGN_LIST', response.data['data']);
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
        (state.proponent_types = list)
    },
    RANK_LIST: (state, list) => {
        (state.ranks = list)
    },
    EMPLOYEE_LIST: (state, list)=> {
        (state.employees = list)
    },
    CAMPAIGN_LIST: (state, list)=> {
        (state.campaigns = list)
    },
    SITE_LIST: (state, list)=> {
        (state.sites = list)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};