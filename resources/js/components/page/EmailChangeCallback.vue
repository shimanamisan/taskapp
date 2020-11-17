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
                    <p>
                        3秒後にトップ画面へ移動します。移動しない場合はブラウザをリロードして下さい。
                    </p>
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
    CREATED,
} from "@/statusCode";
export default {
    data() {
        return {
            authMessage: null,
            auth_flg: true,
        };
    },
    computed: {
        authentication() {
            return !this.authMessage;
        },
        authError() {
            return !this.auth_flg;
        },
    },
    methods: {
        ...mapMutations({
            // this.$store.auth.commit('setId')
            // this.setId(引数)で利用することが可能になる
            setApiStatus: "auth/setApiStatus",
            setUser: "auth/setUser",
            setEmail: "auth/setEmail",
            setPic: "auth/setPic",
            setId: "auth/setId",
        }),
        async emailChangeAuth() {
            this.authMessage = "認証用トークンを確認しています。。。";
            const response = await axios.get("/api/mypage/change_email", {
                params: this.$route.query,
            });
            console.log(response);
            if (response.status === OK) {
                this.authMessage = "メールアドレスを変更しました。";
                this.setApiStatus(true);
                setTimeout(() => {
                    this.$router.push("/profile");
                }, 2000);
                return;
            } else if (response.status === UNPROCESSABLE_ENTITY) {
                // エラーメッセージを格納する
                this.auth_flg = false;
                this.authMessage = response.data.errors.email[0];
                this.setUser(null);
                this.setEmail(null);
                this.setPic(null);
                this.setId(null);
                // バックエンド側でセッションを削除しているので、一旦リロードさせる
                setTimeout(() => {
                    window.location = "/";
                }, 3000);
                return;
            } else if (response.status === INTERNAL_SERVER_ERROR) {
                this.auth_flg = false;
                this.authMessage = response.data.errors.email[0];
                this.setUser(null);
                this.setEmail(null);
                this.setPic(null);
                this.setId(null);
                // バックエンド側でセッションを削除しているので、一旦リロードさせる
                setTimeout(() => {
                    window.location = "/";
                }, 3000);
                return;
            } else {
                this.auth_flg = false;
                this.authMessage =
                    "トークンの有効期限が切れているか、ログインされていません。";
                this.setUser(null);
                this.setEmail(null);
                this.setPic(null);
                this.setId(null);
                // バックエンド側でセッションを削除しているので、一旦リロードさせる
                setTimeout(() => {
                    window.location = "/";
                }, 3000);
                return;
            }
        },
    },
    mounted() {
        this.emailChangeAuth();
    },
};
</script>

<style></style>
