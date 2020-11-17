import Vue from "vue";
import Vuex from "vuex";
import auth from "@/store/auth";
import taskStore from "@/store/taskStore";
import error from "@/store/error";
import contact from "@/store/contact";
import profile from "@/store/profile";

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
