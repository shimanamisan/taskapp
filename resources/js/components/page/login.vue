<template>
    <div class="l-wrapper">
        <section class="l-main__auth">
            <div class="c-logo__header">
                <router-link to="/">
                    <CommonLogo />
                </router-link>
            </div>
            <div class="l-card__container">
                <div class="l-card__content">
                    <div class="p-card__container">
                        <p class="p-card__title">ログイン画面</p>
                        <hr class="u-form__line" />
                    </div>
                </div>
                <!-- end content -->
                <div class="c-form__container">
                    <form @submit.prevent="login">
                        <div class="c-form__item">
                            <label for="login-email" class="c-form-lavel"
                                >メールアドレス</label
                            >

                            <input
                                id="login-email"
                                type="text"
                                class="c-input"
                                v-model="loginFrom.email"
                                :class="{'c-error__bg': loginEmailError}"
                            />
                            <!-- バリデーションエラー -->
                            <div v-if="loginErrors" class="c-error">
                                <ul v-if="loginErrors.email">
                                    <li
                                        v-for="msg in loginErrors.email"
                                        :key="msg"
                                    >
                                        {{ msg }}
                                    </li>
                                </ul>
                            </div>
                            <!-- end errors -->
                        </div>
                        <!-- end c-form__item -->
                        <div class="c-form__item">
                            <label for="login-password" class="c-form-lavel"
                                >パスワード</label
                            >
                            <input
                                id="login-password"
                                type="password"
                                class="c-input"
                                v-model="loginFrom.password"
                                :class="{'c-error__bg': loginPasswordError}"
                            />
                            <!-- バリデーションエラー -->
                            <div v-if="loginErrors" class="c-error">
                                <ul v-if="loginErrors.password">
                                    <li
                                        v-for="msg in loginErrors.password"
                                        :key="msg"
                                    >
                                        {{ msg }}
                                    </li>
                                </ul>
                            </div>
                            <!-- end errors -->
                        </div>
                        <!-- end c-form__item -->
                        <div class="c-form__action">
                            <div class="c-form__action__item">
                                <button
                                    type="submit"
                                    class="c-btn c-btn__login"
                                >
                                    ログインする
                                </button>
                            </div>
                        </div>
                        <div class="c-btn-reminder">
                            <router-link to="/reminder"
                                >パスワードを忘れた方はこちら</router-link
                            >
                        </div>
                    </form>
                    <hr class="u-form__line" />
                    <div class="c-form__action c-form__action--easy">
                        <div class="u-social__item">
                            <button
                                class="c-btn c-btn__twitter"
                                @click="twitterLogin"
                            >
                                Twitterアカウントでログイン・登録
                            </button>
                        </div>
                    </div>
                </div>
                <!-- c-form__container -->
            </div>
            <!-- l-card__container -->
        </section>
        <!-- l-main__auth -->
    </div>
    <!-- l-wrapper__login -->
</template>
<script>
import CommonLogo from "../common/CommonLogo";
import { mapState, mapGetters } from "vuex";
export default {
    data() {
        return {
            loginFrom: {
                email: "",
                password: ""
            }
        };
    },
    components: {
        CommonLogo
    },
    computed: {
        // ...mapStateを使った書き方
        ...mapState({
            apiStatus: state => state.auth.apiStatus,
            loginErrors: state => state.auth.loginErrorMessages
        }),
        ...mapGetters({
            loginEmailError: "auth/getLoginEmailError",
            loginPasswordError: "auth/getLoginPasswordError",
        })

    },
    methods: {
        // authストアのloginアクションを呼び出す
        async login() {
            await this.$store.dispatch("auth/login", this.loginFrom);
            if (this.apiStatus) {
                // 通信が成功（apiStatusがtureの場合）したら移動する
                this.$router.push("/tasklist");
            } 
        },
        async twitterLogin() {
            const response = await axios.get("/api/auth/twitter");

            if (response.status === 200) {
                window.location = response.data.redirect_url;
            } else {
                this.$router.push("/500");
            }
        },
        clearError() {
            this.$store.commit("auth/setLoginErrorMessages", null);
        }
    },
    created() {
        // createdライフサイクルフックで、表示が残っていたバリデーションメッセージを消す
        this.clearError();
    }
};
</script>
<style></style>
