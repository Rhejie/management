import axios from "axios";

const state = {
    asset_classes: [],
    asset_class: {},
    errors: {},
};

const getters = {
    asset_classes: (state) => state.asset_classes,
    getAssetClass: (state) => state.asset_class,
    errors: (state) => state.errors,
};

const actions = {
    async fetchAssetClasses({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/assets/all', {
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
    async fetchAssetClassesByType({ commit, rootGetters }, asset_type_id) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get(`/admin/assets/type/${asset_type_id}`, {
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
    async updateAssetClass({ commit }, asset_class) {
        try {
            const response = await axios.patch('/admin/assets/edit', asset_class)
            commit('UPDATE_ASSET_CLASS', asset_class);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
            
            commit('ERRORS', oError);
        }
    },
    async createAssetClass({ commit }, asset_class) {
        try {
            const response = await axios.post('/admin/assets/create', asset_class)
            
            asset_class['id'] = response.data.message.id;
            commit('ADD', asset_class);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
                
            commit('ERRORS', oError);
        }
    },
    async deleteAssetClass({ commit }, asset_class) {
        try {
            const response = await axios.delete('/admin/assets/delete', { 
                data: { id:asset_class.id }
            });
            commit('REMOVE', asset_class.id);
        } catch (error) {
            commit('ERRORS', error.response)
        }
    },
    resetAssetClassList({commit}){
        commit('LIST', []);
    },
    resetAssetClass({ commit }) {
        commit('RESET_ASSET_CLASS');
    },
    clearErrors({ commit })
    {
        commit('CLEAR_ERRORS');
    },
};

const mutations = {
    ERRORS: (state, error) => {
        console.log(`errors = ${error}`);
        (state.errors = error);
    },
    LIST: (state, list) => {
        (state.asset_classes = list)
    },
    ADD: (state, asset_class) => (state.asset_classes.push(asset_class)),
    RESET_ASSET_CLASS: (state) => (state.asset_class = {
        id: null,
        name: '',
    }),
    CLEAR_ERRORS: (state) => (state.errors = {}),
    REMOVE: (state, id) => (state.asset_classes = state.asset_classes.filter(asset_class => asset_class.id !== id)),
    UPDATE_ASSET_CLASS: (state, asset_class) => {
        const targetClass = state.asset_classes.find(target => target.id === asset_class.id)
        targetClass.name = asset_class.name
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};