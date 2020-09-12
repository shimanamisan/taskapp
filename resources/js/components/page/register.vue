<template>
    <div class="l-wrapper l-wrapper--register">
        <section class="l-main__auth">
            <div class="c-logo__header" id="rink-id">
                <router-link to="/">
                    <CommonLogo />
                </router-link>
            </div>
            <div class="l-card__container">
                <div class="p-card__container">
                    <p class="p-card__title">新規ユーザー登録</p>
                </div>
                <hr class="u-form__line" />
                <div class="c-form__container">
                    <form @submit.prevent="register">
                        <div class="c-form__item">
                            <label for="" class="c-form-lavel"
                                >ニックネーム</label
                            >
                            <input
                                type="text"
                                class="c-input"
                                v-model="registerForm.name"
                                :class="{ 'c-error__bg': registerNameErrors }"
                            />
                            <!-- バリデーションエラー -->
                            <div v-if="registerErrors" class="c-error">
                                <ul v-if="registerErrors.name">
                                    <li
                                        v-for="msg in registerErrors.name"
                                        :key="msg"
                                    >
                                        {{ msg }}
                                    </li>
                                </ul>
                            </div>
                            <!-- end errors -->
                        </div>
                        <div class="c-form__item">
                            <label for="" class="c-form-lavel"
                                >メールアドレス</label
                            >
                            <input
                                type="text"
                                class="c-input"
                                v-model="registerForm.email"
                                :class="{ 'c-error__bg': registerEmailErrors }"
                            />
                            <!-- バリデーションエラー -->
                            <div v-if="registerEmailErrors" class="c-error">
                                <ul v-if="registerErrors.email">
                                    <li
                                        v-for="msg in registerErrors.email"
                                        :key="msg"
                                    >
                                        {{ msg }}
                                    </li>
                                </ul>
                            </div>
                            <!-- end errors -->
                        </div>
                        <div class="c-form__item">
                            <label for="" class="c-form-lavel"
                                >パスワード</label
                            >
                            <input
                                type="password"
                                class="c-input"
                                v-model="registerForm.password"
                                :class="{
                                    'c-error__bg': registerPasswordErrors
                                }"
                            />
                            <!-- バリデーションエラー -->
                            <div v-if="registerErrors" class="c-error">
                                <ul v-if="registerErrors.password">
                                    <li
                                        v-for="msg in registerErrors.password"
                                        :key="msg"
                                    >
                                        {{ msg }}
                                    </li>
                                </ul>
                            </div>
                            <!-- end errors -->
                        </div>
                        <div class="c-form__item">
                            <label for="" class="c-form-lavel"
                                >パスワード再入力</label
                            >
                            <input
                                type="password"
                                class="c-input"
                                v-model="registerForm.password_confirmation"
                            />
                        </div>
                        <div class="">
                            「<router-link to="/rule">利用規約</router-link
                            >」利用規約を必ずご確認ください
                        </div>
                        <div class="c-form__action c-form__action__item">
                            <button type="submit" class="c-btn c-btn__signin">
                                利用規約に同意して新規登録
                            </button>
                        </div>
                    </form>
                    <hr class="u-form__line" />
                    <div class="c-form__action c-form__action--easy">
                        <div class="u-social__item">
                            <button
                                class="c-btn c-btn__twitter"
                                @click="twitterRegister"
                            >
                                Twitterアカウントでログイン・登録
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- l-card__container -->
            <div class="u-redirect__login">
                既に登録済みの方は
                <router-link to="/login">こちら➡</router-link>
            </div>
        </section>
        <!-- l-main__auth -->
    </div>
    <!-- l-wrapper__login -->
</template>
<script>
import CommonLogo from "../common/CommonLogo";
import { mapGetters, mapState } from "vuex";
export default {
    data() {
        return {
            registerForm: {
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            }
        };
    },
    components: {
        CommonLogo
    },
    computed: {
        ...mapState({
            apiStatus: state => state.auth.apiStatus,
            registerErrors: state => state.auth.registerErrorMessages
        }),
        ...mapGetters({
            registerEmailErrors: "auth/getRegisterEmailError",
            registerNameErrors: "auth/getRegisterNameError",
            registerPasswordErrors: "auth/getRegisterPasswordError"
        })
    },
    methods: {
        async register() {
            // await:非同期なアクションの処理が完了するのを待ってから（難しく言うと Promise の解決を待ってから）ページ遷移する
            // authストアのregisterアクションを呼び出す
            await this.$store.dispatch("auth/register", this.registerForm);
            if (this.apiStatus) {
                // 通信が成功（apiStatusがtureの場合）したら移動する
                this.$router.push("/tasklist");
            }
        },
        async twitterRegister() {
            const response = await axios.get("/api/auth/twitter");

            if (response.status === 200) {
                window.location = response.data.redirect_url;
            } else {
                this.$router.push("/500");
            }
        },
        clearError() {
            this.$store.commit("auth/setRegisterErrorMessages", null);
        },
        validMessage() {
            console.log(registerErrors);
        }
    },
    created() {
        // createdライフサイクルフックで、表示が残っていたバリデーションメッセージを消す
        this.clearError();
    }
};
</script>
<style></style>
