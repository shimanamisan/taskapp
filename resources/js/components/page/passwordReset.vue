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
                    <p class="p-card__title">パスワード再設定</p>
                </div>
                <hr class="u-form__line">
                <div class="c-form__container">
                    <form @submit.prevent="">
                        <div class="c-form__item">
                            <label for="" class="c-form-lavel">メールアドレス</label>
                            <!-- バリデーションエラー -->
                            <div v-if="passResetErrors" class="errors">
                                <ul v-if="passResetErrors.email">
                                    <li v-for="msg in passResetErrors.email" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <input type="text" class="c-input" v-model="form.email">
                        </div>
                        <div class="c-form__item">
                            <label for="" class="c-form-lavel">パスワード</label>
                            <!-- バリデーションエラー -->
                            <div v-if="passResetErrors" class="errors">
                                <ul v-if="passResetErrors.password">
                                    <li v-for="msg in passResetErrors.password" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <input type="password" class="c-input" v-model="form.password">
                        </div>
                        <div class="c-form__item">
                            <label for="" class="c-form-lavel">パスワード再入力</label>
                            <!-- バリデーションエラー -->
                            <div v-if="passResetErrors" class="errors">
                                <ul v-if="passResetErrors.password">
                                    <li v-for="msg in passResetErrors.password" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <input type="password" class="c-input" v-model="form.password_confirmation">
                        </div>
                    </form>
                    <div class="c-form__action c-form__action__item">
                        <button class="c-btn c-btn__signin" @click="resetPassword">送信する</button>
                    </div>
                </div>
            </div>
            <!-- l-card__container -->
        </section>
        <!-- l-main__auth -->
    </div>
    <!-- l-wrapper__login -->
</template>
<script>
import { mapState } from 'vuex'
export default {
  data (){
    return {
        form :
          {
            email: '',
            password: '',
            password_confirmation: '',
            token: ''
          },
        requestURL: ''
    }
  },
  computed: {
      ...mapState({
          isLogin: state => getters['auth/check'],
          apiStatus: state => getters['auth/apiStatus'],
          passResetErrors: state => state.auth.passResetErrors
      })
  },
  methods: {
      async resetPassword(){    
          await this.$store.dispatch('auth/resetPassword', this.form )
      },
      setQuery(){
        this.form.token = this.$route.query.token || '';    // パスワードリセットするために必要なToken
      }

  },
  created(){
      this.setQuery()
  }
}
</script>
<style>

</style>