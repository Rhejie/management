import axios from "axios";

const state = {
    asset_subclasses: [],
    asset_subclass: {},
    errors: {},
};

const getters = {
    asset_subclasses: (state) => state.asset_subclasses,
    getAssetSubClass: (state) => state.asset_subclass,
    errors: (state) => state.errors,
};

const actions = {
    async fetchAssetSubClasses({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/assets/subclasses/all', {
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

    async fetchSelectedAssetSubClasses({ commit, rootGetters }, asset_class_id) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get(`/admin/assets/subclasses/view/${asset_class_id}`, {
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
    async updateAssetSubClass({ commit }, asset_subclass) {
        try {
            // asset_subclass['asset_class_id'] = asset_subclass.asset_class.id
            const response = await axios.patch('/admin/assets/subclasses/edit', asset_subclass)
            commit('UPDATE_ASSET_CLASS', asset_subclass);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
            
            commit('ERRORS', oError);
        }
    },
    async createAssetSubClass({ commit }, asset_subclass) {
        try {
            // asset_subclass['asset_class_id'] = asset_subclass.asset_class.id
            const response = await axios.post('/admin/assets/subclasses/create', asset_subclass)
            asset_subclass['id'] = response.data.message.id;
            commit('ADD', asset_subclass);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
                
            commit('ERRORS', oError);
        }
    },
    async deleteAssetSubClass({ commit }, asset_subclass) {
        try {
            const response = await axios.delete('/admin/assets/subclasses/delete', { 
                data: { id:asset_subclass.id }
            });
            commit('REMOVE', asset_subclass.id);
        } catch (error) {
            commit('ERRORS', error.response)
        }
    },
    resetAssetSubClassList({commit}){
        commit('LIST', []);
    },
    resetAssetSubClass({ commit }) {
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
        (state.asset_subclasses = list)
    },
    ADD: (state, asset_subclass) => {
        (state.asset_subclasses.push(asset_subclass))
    },
    RESET_ASSET_CLASS: (state) => (state.asset_subclass = {
        id: null,
        name: "",
        asset_class_id: null,
        asset_class_name: "",
        asset_class: {
            id:null,
            name:"",
        }
    }),
    CLEAR_ERRORS: (state) => (state.errors = {}),
    REMOVE: (state, id) => (state.asset_subclasses = state.asset_subclasses.filter(asset_subclass => asset_subclass.id !== id)),
    UPDATE_ASSET_CLASS: (state, asset_subclass) => {
        const targetSubClass = state.asset_subclasses.find(target => target.id === asset_subclass.id)
        targetSubClass.name = asset_subclass.name
        targetSubClass.asset_class.id = asset_subclass.asset_class.id;
        targetSubClass.asset_class.name = asset_subclass.asset_class.name;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};