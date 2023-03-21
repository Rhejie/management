import axios from "axios";

const state = {
    asset_summary: {},
    errors: {},
};

const getters = {
    asset_summary: (state) => state.asset_summary,
    errors: (state) => state.errors,
};

const actions = {
    async getAssetSummary({ commit, rootGetters }, brand_model_id) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get(`/admin/brands/models/asset-summary/${brand_model_id}`, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            })
            commit('ASSET_SUMMARY',response.data.data)
            
        } catch (error) {            
            commit('ERRORS', error.response.data);
        }
    },
    setAssetSummary({commit}, asset)
    {
        commit('ASSET_SUMMARY', asset)
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
    ASSET_SUMMARY: (state, asset_summary) => {
        (state.asset_summary = asset_summary)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};