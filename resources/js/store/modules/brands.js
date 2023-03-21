import axios from "axios";
import VueCookies from 'vue-cookies'
import auth from "./auth";

const token = auth.state.token;
axios.defaults.headers.common = { 'Authorization': `Bearer ${token}` };

const state = {
    brands: [],
    brand: {
        id: null,
        name: '',
        asset_class_id: null,
        asset_subclass_id: null,
        // company_name: ''
    },
    response: {},
    token: '',
    errors: {},
    hasErrors: false,
};

const getters = {
    allBrands: (state) => state.brands,
    getErrors: (state) => state.errors,
    getBrand: (state) => state.brand,
};

const actions = {
    async fetchBrands({ commit }) {
        try {
            const response = await axios.get('/admin/brands/all');
            const list = response.data['data'];
            commit('BRAND_LIST', list);
        } catch (error) {
            commit('ERRORS', error.response.data)
        }
    },
    async fetchSelectedBrands({ commit }, sub_class_id) {
        try {
            const response = await axios.get(`/admin/brands/view/${sub_class_id}`);
            const list = response.data['data'];
            commit('BRAND_LIST', list);
        } catch (error) {
            commit('ERRORS', error.response.data)
        }
    },
    async createBrand({ commit }, brand) {
        try {
            const response = await axios.post('/admin/brands/create', brand)
            commit('ERRORS', []);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for (const f in eResp.message)
                oError[f] = eResp.message[f][0];

            commit('ERRORS', oError);
        }
    },
    async updateBrand({ commit }, brand) {
        try {
            const response = await axios.patch('/admin/brands/edit', brand)
            commit('ERRORS', []);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for (const f in eResp.message)
                oError[f] = eResp.message[f][0];

            commit('ERRORS', oError);
        }
    },
    async deleteBrand({ commit }, brand) {
        try {
            const response = await axios.delete('/admin/brands/delete', {
                data: { id: brand.id }
            });
            commit('REMOVE', brand.id);
        } catch (error) {
            commit('ERRORS', error.response)
        }
    },
    clearErrors({ commit }) {
        commit('CLEAR_ERRORS');
    },
    setBrand({ commit }, brand) {
        commit('SET_BRAND', brand);
    },
    resetBrandList({ commit }) {
        commit('BRAND_LIST', []);
    },
    resetBrand({ commit }) {
        commit('RESET_BRAND');
    }
};

const mutations = {
    ERRORS: (state, error) => (state.errors = error),
    BRAND_LIST: (state, list) => (state.brands = list),
    ADD: (state, brand) => (state.brands.push(brand)),
    REMOVE: (state, id) => (state.brands = state.brands.filter(brand => brand.id !== id)),
    CLEAR_ERRORS: (state) => (state.errors = {}),
    RESET_BRAND: (state) => (state.brand = {
        id: null,
        name: '',
        asset_class_id: null,
        asset_subclass_id: null,
        // company_name: ''
    }),
    SET_BRAND: (state, brand) => (state.brand = brand),
    UPDATE_BRAND: (state, brand) => {
        const targetBrand = state.brands.find(target => target.id === brand.id)
        targetBrand.name = brand.name
        targetBrand.asset_class_id = brand.asset_class_id
        targetBrand.asset_subclass_id = brand.asset_subclass_id
        // targetBrand.company_name = brand.company_name
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};