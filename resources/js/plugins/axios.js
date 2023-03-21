import axios from 'axios';
import store from '../store';

axios.defaults.baseURL = "/api/";

store.dispatch('auth/getToken');

var token = store.getters['auth/getToken'];

if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}