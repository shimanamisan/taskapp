/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', 
// require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue'
import App from './App.vue'
import store from './store/store'
import router from './router'

Vue.config.devtools = true;

// Vueインスタンスを生成する前にログインチェックを行うように変更
// 非同期処理をawaitするには、asyncメソッドの内部に配置する必要があるので関数にまとめた
// createApp()の中にVueインスタンス生成もまとめている
const createApp = async function(){
  await store.dispatch('auth/currentUser')

    new Vue({
      router,
      store,
      
      // h(App)の引数にApp.vueコンポーネントのオブジェクトが入ってくる
      // renderではコンポーネントのオブジェクト（テンプレートやメソッドなど）を突っ込んで描画することができる 
      render: h => h(App)
    }).$mount('#app')

}

createApp()

// ES5の書き方
// const app = new Vue({
//     el: '#app',
//     components: { App }
// });
