import axios from "axios";

const state = {
    brand_models: [],
    brand_model: {},
    errors: {},
};

const getters = {
    brand_models: (state) => state.brand_models,
    getBrandModel: (state) => state.brand_model,
    errors: (state) => state.errors,
};

const actions = {
    async fetchBrandModels({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/brands/models/all', {
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
    async fetchSelectedBrandModels({ commit, rootGetters }, brand_id) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get(`/admin/brands/models/view/${brand_id}`, {
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
    async updateBrandModel({ commit }, brand_model) {
        try {
            // console.log(brand_model);return
            const response = await axios.patch('/admin/brands/models/edit', brand_model)
            commit('UPDATE_BRAND_MODELS', brand_model);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
            
            commit('ERRORS', oError);
        }
    },
    async createBrandModel({ commit }, brand_model) {
        try {
            // console.log(brand_model);return
            const response = await axios.post('/admin/brands/models/create', brand_model)
            brand_model['id'] = response.data.message.id;
            commit('ADD', brand_model);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
                
            commit('ERRORS', oError);
        }
    },
    async brandModelSearch({ commit }, search_name) {
        try {
            const response = await axios.post('/admin/brands/models/search', search_name);

            commit('LIST', response.data['data']);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },
    async brandModelSearchAll({ commit }, search_name) {
        try {
            const response = await axios.post('/admin/brands/models/search-all', search_name);

            commit('LIST', response.data['data']);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },
    async deleteBrandModel({ commit }, brand_model) {
        try {
            const response = await axios.delete('/admin/brands/models/delete', { 
                data: { id:brand_model.id }
            });
            commit('REMOVE', brand_model.id);
        } catch (error) {
            commit('ERRORS', error.response)
        }
    },
    resetBrandModel({ commit }) {
        commit('RESET_BRAND_MODELS');
    },
    resetBrandModelList({ commit }) {
        commit('LIST', []);
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
        (state.brand_models = list)
    },
    ADD: (state, brand_model) => {
        (state.brand_models.push(brand_model))
    },
    RESET_BRAND_MODELS: (state) => (state.brand_model = {
        id: null,
        name: "",
        brand_id: null,
        brand_name: "",
        brand: {
            id:null,
            name:"",
        }
    }),
    CLEAR_ERRORS: (state) => (state.errors = {}),
    REMOVE: (state, id) => (state.brand_models = state.brand_models.filter(brand_model => brand_model.id !== id)),
    UPDATE_BRAND_MODELS: (state, brand_model) => {
        const targetBrandModel = state.brand_models.find(target => target.id === brand_model.id)
        console.log('commit',brand_model);
        console.log('old',targetBrandModel);
        targetBrandModel.name = brand_model.name
        targetBrandModel.brand.id = brand_model.brand_id;
        targetBrandModel.brand.name = brand_model.brand_name;
        targetBrandModel.brand.description = brand_model.description;
        console.log('new',targetBrandModel);
        return
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};