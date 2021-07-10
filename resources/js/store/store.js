import Vue from "vue";
import Vuex from "vuex";
import auth from "@js/store/auth";
import taskStore from "@js/store/taskStore";
import error from "@js/store/error";
import contact from "@js/store/contact";
import profile from "@js/store/profile";

// Vuexを使うよという宣言
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        taskStore,
        error,
        contact,
        profile,
    },
});
