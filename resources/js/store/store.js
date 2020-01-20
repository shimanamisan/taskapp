import Vue from 'vue';
import Vuex from 'vuex';
import auth from './auth';

// Vuexを使うよという宣言
Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    auth,
    
  }
})