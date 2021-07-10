<template>
        <router-view></router-view>
</template>

<script>
// エラーコードモジュールを読み込む
import { UNAUTHORIZED, INTERNAL_SERVER_ERROR } from "@js/statusCode";

export default {
    data() {
        return {};
    },
    computed: {
        errorCode() {
            return this.$store.state.error.code;
        },
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
                    this.$router.push("/login");
                }
            },
            immediate: true,
        },
        $route() {
            this.$store.commit("error/setCode", null);
        },
    },
};
</script>

<style>
</style>
