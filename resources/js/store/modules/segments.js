import axios from "axios";
import VueCookies from 'vue-cookies'
import auth from "./auth";

const token = auth.state.token;
axios.defaults.headers.common = {'Authorization': `Bearer ${token}`};

const state = {
    segments: [],
    segment: {
        id: null,
        name: '',
    },
    response: {},
    token: '',
    errors: {},
    hasErrors: false,
};

const getters = {
    segments: (state) => state.segments,
    getErrors: (state) => state.errors,
    getSegment: (state) => state.segment,
};

const actions = {
    async fetchSegments({ commit }) {
        try {
            const response = await axios.get('/admin/segments/all');
            const list = response.data['data'];
            commit('SEGMENT_LIST', list);
        } catch (error) {
            commit('ERRORS', error.response.data)
        }
    },
    async createSegment({ commit }, segment) {
        try {
            const response = await axios.post('/admin/segments/create', segment)
            segment['id'] = response.data.message.id;
            commit('ADD', segment);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
                
            commit('ERRORS', oError);
        }
    },
    async updateSegment({ commit }, segment) {
        try {
            const response = await axios.patch('/admin/segments/edit', segment)
            commit('UPDATE_SEGMENT', segment);
        } catch (error) {
            const eResp = error.response.data
            var oError = {};

            for(const f in eResp.message)
                oError[f]=eResp.message[f][0];
            
            commit('ERRORS', oError);
        }
    },
    async deleteSegment({ commit }, segment) {
        try {
            const response = await axios.delete('/admin/segments/delete', { 
                data: { id:segment.id }
            });
            commit('REMOVE', segment.id);
        } catch (error) {
            commit('ERRORS', error.response)
        }
    },
    clearErrors({ commit })
    {
        commit('CLEAR_ERRORS');
    },
    setSegment({ commit }, segment) {
        commit('SET_SEGMENT', segment);
    },
    resetSegment({ commit }) {
        commit('RESET_SEGMENT');
    }
};

const mutations = {
    ERRORS: (state, error) => (state.errors = error),
    SEGMENT_LIST: (state, list) => (state.segments = list),
    ADD: (state, segment) => (state.segments.push(segment)),
    REMOVE: (state, id) => (state.segments = state.segments.filter(segment => segment.id !== id)),
    CLEAR_ERRORS: (state) => (state.errors = {}),
    RESET_SEGMENT: (state) => (state.segment = {
        id: null,
        name: '',
    }),
    SET_SEGMENT: (state,segment) => (state.segment = segment),
    UPDATE_SEGMENT: (state, segment) => {
        const targetSegment = state.segments.find(target => target.id === segment.id)
        targetSegment.name = segment.name

    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};