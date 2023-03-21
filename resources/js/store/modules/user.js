import axios from "axios";

const state = {
    users: [],
    user: {
        id: null,
        name: '',
        role_id: null,
        password: null,
        status: null,
        email: '',
    },
    errors: null,
}

const getters = {
    users: (state) => state.users,
    user: (state) => state.user,
    errors: (state) => state.errors,
}

const actions = {
    async fetchUsers({ commit, rootGetters }) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.get('/admin/users/all', {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            const list = response.data['data'];
            commit('USER_LIST', list);
        } catch (error) {
            commit('ERRORS', error);
        }
    },
    assignUser({ commit }, user){
        commit('UPDATE_USER', user);
    },
    async updateProfile({ commit, rootGetters }, credentials) {
        try {
            const token = rootGetters['auth/getToken'];
            const response = await axios.patch('/admin/users/profile-update', credentials, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            commit('ERRORS', response.data);
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },
    resetError({commit}){
        commit('ERRORS', null);
    }
}

const mutations = {
    ERRORS: (state, error) => {
        (state.errors = error);
    },
    USER_LIST: (state, list) => {
        (state.users = list)
    },
    UPDATE_USER: (state, user) => {
        (state.user = user)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};