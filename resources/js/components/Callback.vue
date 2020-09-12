<template>
    <div class="l-wrapper p-callback">
        <div class="p-callback__wrapp">
            <div
                class="p-callback__wrapp__inner"
                :class="{ 'p-callback__auth--error': authError }"
            >
                <p
                    class="p-callback__wrapp__text p-callback__auth"
                    v-if="auth_flg"
                >
                    {{ authMessage }}
                </p>
                <div v-else>
                    <p class="p-callback__wrapp__text">{{ authMessage }}</p>
                    <router-link class="c-btn u-btn__callback" to="/login"
                        >ログインページに戻る</router-link
                    >
                </div>
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
        },
        authError() {
            return !this.auth_flg;
        }
    },
    methods: {
        ...mapMutations({
            // this.$store.auth.commit('setId')
            // this.setId(引数)で利用することが可能になる
            setApiStatus: "auth/setApiStatus",
            setUser: "auth/setUser",
            setEmail: "auth/setEmail",
            setPic: "auth/setPic",
            setId: "auth/setId"
        }),
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
                    console.log(response);
                    this.setApiStatus(response.status);
                    this.setEmail(response.data.email);
                    this.setUser(response.data.name);
                    this.setPic(response.data.pic);
                    this.setId(response.data.id);
                    setTimeout(() => {
                        this.$router.push("/tasklist");
                    }, 2000);
                    return;
                }
            } else if (response.status === UNPROCESSABLE_ENTITY) {
                // エラーメッセージを格納する
                this.auth_flg = false;
                this.authMessage = response.data.error_message;
                return;
            }
        }
    },
    mounted() {
        this.callbackTwitterLogin();
    }
};
</script>

<style></style>
