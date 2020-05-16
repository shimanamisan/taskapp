require("./bootstrap");

import Vue from "vue";
import App from "./App.vue";
import store from "./store/store";
import router from "./router";

// Vue.config.devtools = false

// Vueインスタンスを生成する前にログインチェックを行うように変更
// 非同期処理をawaitするには、asyncメソッドの内部に配置する必要があるので関数にまとめた
// createApp()の中にVueインスタンス生成もまとめている

new Vue({
    router,
    store,
    beforeCreate() {
        store.dispatch("auth/currentUser");
    },
    // h(App)の引数にApp.vueコンポーネントのオブジェクトが入ってくる
    // renderではコンポーネントのオブジェクト（テンプレートやメソッドなど）を突っ込んで描画することができる
    render: h => h(App)
}).$mount("#app");

// new Vue({
//   el: '#app',
//   router, // ルーティングの定義を読み込む
//   store,
//   components: { App }, // ルートコンポーネントの使用を宣言する
//   template: '<App />' // ルートコンポーネントを描画する
// })
