<template>
    <div class="l-wrapper l-wrapper__reminder">
        <section class="l-main__auth">
            <div class="c-logo__header">
                <router-link to="/">
                    <img src="../../../img/logo.png" alt="logo" class="c-logo">
                </router-link>
            </div>
            <div class="l-card__container">
                <div class="p-card__container">
                    <p class="p-card__title">パスワード再設定する</p>
                </div>
                <hr class="u-form__line">
                <div class="c-form__container">
                    <form @submit.prevent>
                        <div class="c-form">
                            <label for="" class="c-form-lavel">登録メールアドレス</label>
                                <!-- メッセージ表示用 --->
                                <ul v-if="sendEmailMessages" class="message">
                                    <span>{{ sendEmailMessages }}</span>
                                </ul>
                                <!--- end message -->
                            <!-- バリデーションエラー --->
                            <ul v-if="reminderErrorMessages" class="errors errors--tasks">
                                <li v-for="(msg, index) in reminderErrorMessages.email" :key="index">{{ msg }} </li>
                            </ul>
                            <!--- end errors -->
                            <input type="text" class="c-input" v-model="sendEmail" @blur="this.clearError">
                        </div>
                    </form>
                    <div class="c-form__action c-form__action__item">
                        <button class="c-btn c-btn__signin" @click="sendResetLinkEmail">送信する</button>
                    </div>
                </div>
            </div>
            <!-- l-card__container -->
            <div class="u-redirect__login">既に登録済みの方は
                <router-link to="/login">こちら➡</router-link>
            </div>
        </section>
        <!-- l-main__auth -->
    </div>
    <!-- l-wrapper__login -->
</template>
<script>
import { OK, UNPROCESSABLE_ENTITY, INTERNAL_SERVER_ERROR, CREATED } from '../../statusCode'

export default {
    data(){
        return{
            sendEmail: ''
        }
    },
        computed: {
        sendEmailMessages(){
            // エラーメッセージがあった際にストアより取得
            return this.$store.state.auth.sendEmailMessages
        },
        reminderErrorMessages(){
            // エラーメッセージがあった際にストアより取得
            return this.$store.state.auth.reminderErrorMessages
        },
        getErrorCode(){
            return this.$store.state.error.code
        }
    },
    methods: {
        async sendResetLinkEmail(){
            const sendEmail = this.sendEmail
            await this.$store.dispatch('auth/sendResetLinkEmail', sendEmail)
        },
        clearError(){
        this.$store.commit('auth/setReminderErrorMessages', null)
      },
    }
}
</script>
<style>

</style>