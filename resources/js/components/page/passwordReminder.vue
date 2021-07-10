<template>
    <div class="l-wrapper l-wrapper__reminder">
        <section class="l-main__auth">
            <div class="c-logo__header">
                <router-link to="/">
                    <CommonLogo />
                </router-link>
            </div>
            <div class="l-card__container">
                <div class="p-card__container">
                    <p class="p-card__title">パスワード再設定する</p>
                </div>
                <hr class="u-form__line" />
                <div class="c-form__container">
                    <form @submit.prevent>
                        <div class="">
                            <!-- メッセージ表示用 --->
                            <ul v-if="sendEmailMessages" class="u-sendMail">
                                <span>{{ sendEmailMessages }}</span>
                            </ul>
                            <!--- end message -->
                            <label for class="c-form-lavel"
                                >登録メールアドレス</label
                            >

                            <input
                                type="text"
                                class="c-input"
                                v-model="sendEmail"
                                :class="{ 'c-error__bg': validEmail }"
                            />
                            <!-- バリデーションエラー --->
                            <ul
                                v-if="resetPasswordErrorMessages"
                                class="c-error c-error--tasks"
                            >
                                <li
                                    v-for="(msg,
                                    index) in resetPasswordErrorMessages.email"
                                    :key="index"
                                >
                                    {{ msg }}
                                </li>
                            </ul>
                            <!--- end errors -->
                        </div>
                    </form>
                    <div class="c-form__action c-form__action__item">
                        <button
                            class="c-btn c-btn__signin"
                            @click="sendResetLinkEmail"
                        >
                            送信する
                        </button>
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
import CommonLogo from "@js/components/common/CommonLogo";
import { mapState, mapGetters } from "vuex";
export default {
    data() {
        return {
            sendEmail: "",
        };
    },
    components: {
        CommonLogo,
    },
    computed: {
        ...mapState({
            sendEmailMessages: (state) => state.auth.sendEmailMessages,
            resetPasswordErrorMessages: (state) =>
                state.auth.passwordReminderErrorMessages,
        }),
        ...mapGetters({
            getCode: "error/getCode",
            validEmail: "auth/validPasswordReminderErrorMessages",
        }),
    },
    methods: {
        async sendResetLinkEmail() {
            const sendEmail = this.sendEmail;
            await this.$store.dispatch("auth/sendResetLinkEmail", sendEmail);
        },
        clearError() {
            this.$store.commit("auth/sendEmailMessages", null);
            this.$store.commit("auth/setPasswordReminderErrorMessages", null);
        },
    },
    created() {
        this.clearError();
    },
};
</script>
<style></style>
