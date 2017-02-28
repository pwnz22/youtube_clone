// window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
import axios from 'axios'

window.axios = axios
axios.defaults.headers.commin = {
    'X-Requested-With': 'XMLHttpRequest'
}

axios.interceptors.request.use(function (config) {
   config.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;
   return config;
});