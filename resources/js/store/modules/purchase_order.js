import axios from "axios";
import router from "../../router";

const state = {
    purchase_orders: [],
    errors: {},
    purchase_order: {},
    po_number: null
};

const getters = {
    purchase_orders: (state) => state.purchase_orders,
    errors: (state) => state.errors,
    purchase_order: (state) => state.purchase_order
};

const actions = {
    async fetchPurchaseOrders({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/purchase-orders/all', {
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
    async createPurchaseOrders({ commit, rootGetters }, asset) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.post('/admin/purchase-orders/create',asset, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            console.log(`response ${JSON.stringify(response.data)}`)
            commit('ERRORS', {});
        } catch (error) {
            commit('ERRORS', error.response.data['message']);
        }
    },
    async updatePurchaseOrder({ commit, rootGetters }, asset) {
        asset['id'] = asset.purchase_order_id
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.post('/admin/purchase-orders/edit',asset, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            console.log(`response ${JSON.stringify(response.data)}`)
            commit('ERRORS', {});
        } catch (error) {
            commit('ERRORS', error.response.data['message']);
        }
    },
    resetError({ commit }){
        commit('ERRORS', {});
    },
    selectPurchaseOrder({ commit }, purchase_order) {
        commit('SELECTED', purchase_order);
    },
    async fetchPurchaseOrder({ commit, rootGetters }) {
        let po_number = rootGetters['purchase_order/purchase_order'].po_number
        commit('SET_PO_NUMBER', po_number)
        if(!po_number)
            router.push({ path: "asset-registry"})

        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/purchase-orders/view/' + po_number, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('LIST', list);
        } catch (error) {
            commit('ERRORS', error);
        }
    }
};

const mutations = {
    ERRORS: (state, error) => {
        console.log(`errors = ${error}`);
        (state.errors = error);
    },
    LIST: (state, list) => {
        (state.purchase_orders = list)
    },
    SELECTED: (state, purchase_order) => {
        (state.purchase_order = purchase_order)
    },
    SET_PO_NUMBER: (state, po_number) => {
        (state.po_number = po_number)
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};