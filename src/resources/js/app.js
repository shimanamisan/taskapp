require("./bootstrap");

import "@sass/style.scss";
import Vue from "vue";
import App from "@js/App.vue";
import store from "@js/store/store";
import router from "@js/router";

// Vueインスタンスを生成する前にログインチェックを行うように変更
// 非同期処理をawaitするには、asyncメソッドの内部に配置する必要があるので関数にまとめた
// createApp()の中にVueインスタンス生成もまとめている

// new Vue({
//     store,
//     router,
//     // beforeCreate() {
//     //     console.log("フロント側の認証確認");
//     //     store.dispatch("auth/currentUser");
//     // },
//     // h(App)の引数にApp.vueコンポーネントのオブジェクトが入ってくる
//     // renderではコンポーネントのオブジェクト（テンプレートやメソッドなど）を突っ込んで描画することができる
//     render: h => h(App)
// }).$mount("#app");

const createApp = async () => {
    // storeは既にインポートしているので、Vueインスタンス生成前でもdispatchメソッドを呼び出せる
    await store.dispatch("auth/currentUser");

    new Vue({
        el: "#app",
        router,
        store,
        components: { App },
        template: "<App />",
    });
};

createApp();
