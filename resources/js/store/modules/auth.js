import axios from "axios";
import VueCookies from 'vue-cookies'

const state = {
    role: 'none',
    token: '',
    errors: '',
    permissions: [],
    authenticated: false,
};

const getters = {
    getToken: (state) => state.token,
    isAuthenticated: (state) => state.authenticated,
    position: (state) => state.role,
    errors: (state) => state.errors,
};

const actions = {
    saveToken({ commit }, credentials) {
        commit('SAVE_TOKEN', credentials.token);
        commit('CHANGE_AUTH', true);
        commit('SAVE_PERMISSIONS', credentials.permissions);
        commit('SAVE_ROLE', credentials.role);
    },
    deleteToken({ commit }) {
        commit('REMOVE_TOKEN');
        commit('CHANGE_AUTH', false);
        commit('SAVE_ROLE', 'none');
        $cookies.remove('vuex');
    },
    getToken({ commit, state }) {
        var token = state.token;
        commit('SAVE_TOKEN', token);
        if (token) {
            commit('CHANGE_AUTH', true);
        }
    },
    saveAuth({ commit, state }, credentials) {
        const token = state.token;
        commit('SAVE_TOKEN', token);
        commit('SAVE_ROLE', credentials.role);
        commit('SAVE_PERMISSIONS', credentials.permissions);
        commit('CHANGE_AUTH', credentials.isAuthenticated);
    },
    initialErrors({commit}){
        commit('ERRORS', null)
    },
    async checkAuthentication({ dispatch, state }) {
        try {
            const token = state.token;
            let response = await axios.post('token-check', {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });

            const authentication = {
                role: response.data['role'],
                isAuthenticated: response.data['authenticated'],
                permissions: response.data['permissions'],
            };

            dispatch('saveAuth', authentication);
        } catch (error) {
            console.log('Unattenticated');
            dispatch('deleteToken');
        }

    },
    async login({ commit, dispatch }, credentials) {
        try {
            const response = await axios.post('login', credentials);
            if (response.data['error']) {
                commit('ERRORS', { email: ['Unauthorized account'] });
            }
            else {
                const credentials = {
                    role: response.data['role'],
                    token: response.data['token'],
                    permissions: response.data['permissions'],
                }
                dispatch('saveToken', credentials);
            }
        } catch (error) {
            commit('ERRORS', error.response.data['message']);
        }
    },
    async register({ commit, state }, credentials) {
        try {
            const token = state.token;
            const response = await axios.post('/admin/register', credentials, {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            commit('SAVE_RESPONSE', `${response.data['message']} with password ${response.data['generated_password']}`);
            commit('ERRORS', { error: false, message: '' });
        } catch (error) {
            commit('ERRORS', error.response.data);
        }
    },
    async logout({ dispatch, commit, state }) {
        try {
            const token = state.token;
            await axios.post('logout', {
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            });
            dispatch('deleteToken');
        } catch (error) {
            commit('ERRORS', error.response.data['message']);
        }
    },
    resetError({commit}){
        commit('ERRORS', '');
    }
};

const mutations = {
    ERRORS: (state, error) => {
        console.log(`errors = ${JSON.stringify(error)}`);
        (state.errors = error);
    },
    SAVE_TOKEN: (state, token) => {
        (state.token = token)
    },
    REMOVE_TOKEN: (state) => {
        (state.token = '')
    },
    CHANGE_AUTH: (state, authentication) => {
        (state.authenticated = authentication)
    },
    SAVE_ROLE: (state, role) => {
        (state.role = role)
    },
    SAVE_RESPONSE: (state, response_message) => {
        (state.response_message = response_message)
    },
    SAVE_PERMISSIONS: (state, permissions) => {
        (state.permissions = permissions)
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};