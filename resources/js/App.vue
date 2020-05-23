<template>
    <!-- <Loading v-show="loading"></Loading> -->
    <transition name="fade" mode="out-in">
        <router-view></router-view>
    </transition>
</template>

<script>
// エラーコードモジュールを読み込む
import { UNAUTHORIZED, INTERNAL_SERVER_ERROR } from "./statusCode";
// import Loading from './components/loading/Loading'

export default {
    data() {
        return {
            //  loading: true
        };
    },
    components: {
        // Loading
    },
    // mounted(){
    //   setTimeout( function(){
    //     this.loading = false
    //   }, 1000)
    // },
    computed: {
        errorCode() {
            return this.$store.state.error.code;
        }
    },
    watch: {
        // ストアのステートを算出プロパティで参照し、それをウォッチャーで監視する
        errorCode: {
            async handler(val) {
                if (val === INTERNAL_SERVER_ERROR) {
                    this.$router.push("/500");
                } else if (val === UNAUTHORIZED) {
                    // トークンをリフレッシュ
                    await axios.get("api/refresh-token");
                    // ストアのユーザー情報をクリア
                    this.$store.commit("auth/setUser", null);
                    this.$store.commit("auth/setEmail", null);
                    this.$store.commit("auth/setPic", null);
                    this.$store.commit("auth/setId", null);
                    // ログイン画面へ
                    this.$router.push("/index");
                }
            },
            immediate: true
        },
        $route() {
            this.$store.commit("error/setCode", null);
        }
    }
};
</script>

<style>
.fade-enter,
.fade-leave-to {
    opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
</style>
