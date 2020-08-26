<template>
    <div class="l-wrapper p-callback">
        <div class="p-callback__wrapp">
            <div class="p-callback__wrapp__inner">
                <p class="p-callback__wrapp__text" v-if="auth_flg">{{ authMessage }}</p>
                <p class="p-callback__wrapp__text" v-else>{{ authMessage }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import { mapMutations } from "vuex";
import {
    OK,
    UNPROCESSABLE_ENTITY,
    INTERNAL_SERVER_ERROR,
    CREATED
} from "../statusCode";
export default {
    data() {
        return {
            authMessage: null,
            auth_flg: true
        };
    },
    computed: {
        authentication() {
            return !this.authMessage;
        }
    },
    methods: {
        async callbackTwitterLogin() {
            this.authMessage = "Twitterでログインを行っています。。。";
            const response = await axios.get("/api/auth/twitter/callback", {
                params: this.$route.query
            });
            if (response.status === OK) {
                if (this.$route.query.denied) {
                    this.auth_flg = false;
                    this.authMessage =
                        "認証に失敗しました。ログインページへ戻ります。";
                    setTimeout(() => {
                        this.$router.push("/login");
                    }, 2000);
                    return;
                } else {
                    this.authMessage = "認証に成功しました。";
                    this.setApiStatus(response.status);
                    this.setEmail(response.data.email);
                    this.setUser(response.data.name);
                    this.setPic(response.data.pic);
                    this.setId(response.data.id);
                    setTimeout(() => {
                        this.$router.push("/");
                    }, 2000);
                    return;
                }
            } else if (response.status === UNPROCESSABLE_ENTITY) {
                // エラーメッセージを格納する
                this.authMessage = response.data.error_message;
                // メッセージを表示した2秒後に、トップページへリダイレクトする
                setTimeout(() => {
                    this.$router.push("/");
                }, 2000);
                return;
            }
        },
        ...mapMutations({
            // this.$store.auth.commit('setId')
            // this.setId(引数)で利用することが可能になる
            setApiStatus: "auth/setApiStatus",
            setUser: "auth/setUser",
            setEmail: "auth/setEmail",
            setPic: "auth/setPic",
            setId: "auth/setId"
        })
    },
    mounted() {
        this.callbackTwitterLogin();
    }
};
</script>

<style></style>
