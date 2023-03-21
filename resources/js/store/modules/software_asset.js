import axios from "axios";

const state = {
    software_assets: [],
    software_asset: {},
    errors: {},
};

const getters = {
    software_assets: (state) => state.software_assets,
    software_asset: (state) => state.software_asset,
    errors: (state) => state.errors,
};

const actions = {
    async fetchSoftwareAssets({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/software-assets/all', {
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
    async fetchSoftwareInventory({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/brands/models/software-inventory', {
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
    async createSoftwareAsset({ commit, rootGetters }, software_asset) {
        try {
            const token = rootGetters['auth/getToken'];
            software_asset['headers'] = {"Authorization": `Bearer ${token}`};
            const response = await axios.post('/admin/software-assets/create', software_asset)
            commit('CLEAR_ERRORS');
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
            
            commit('ERRORS', oError);
        }
    },
    async updateSoftwareAsset({ commit, rootGetters }, software_asset) {
        try {
            const token = rootGetters['auth/getToken'];
            software_asset['headers'] = {"Authorization": `Bearer ${token}`};
            const response = await axios.post('/admin/software-assets/edit', software_asset)
            commit('CLEAR_ERRORS');
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
            
            commit('ERRORS', oError);
        }
    },

    async getAssetSummary({ commit, rootGetters }, brand_model_id) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get(`/admin/brands/models/asset-summary/${brand_model_id}`, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            })
            commit('SET_SOFTWARE_ASSET',response.data.data)
            
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
            
            commit('ERRORS', oError);
        }
    },
    
    async getSoftwareAsset({ commit, rootGetters }, id) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/software-assets/view/'+id, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            })
            commit('SET_SOFTWARE_ASSET',response.data.data)
            
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
            
            commit('ERRORS', oError);
        }
    },
};

const mutations = {
    ERRORS: (state, error) => {
        console.log(`errors = ${error}`);
        (state.errors = error);
    },
    LIST: (state, list) => {
        (state.software_assets = list)
    },
    CLEAR_ERRORS: (state) => (state.errors = {}),
    SET_SOFTWARE_ASSET: (state, software_asset) => {
        (state.software_asset = software_asset)
        software_asset['asset_type_id'] = 2;
        // software_asset['status'] = 
        // console.log(`asset = ${software_asset}`);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};