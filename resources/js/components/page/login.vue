<template>
  <div class="l-wrapper">
      <section class="l-main__auth">
          <div class="c-logo__header">
            <router-link to="/"><img src="../../../img/logo.png" alt="logo" class="c-logo"></router-link>
          </div>
          <div class="l-card__container">
              <div class="l-card__content">
                <div class="p-card__container">
                  <p class="p-card__title">ログイン画面</p>
                  <hr class="u-form__line">
                </div>
              </div><!-- end content -->
              <div class="c-form__container">
                  <form @submit.prevent="login">
                      <div class="c-form__item">
                        <label for="login-email" class="c-form-lavel">メールアドレス</label>
                        <input id="login-email" type="text" class="c-input" v-model="loginFrom.email">
                      </div>
                      <div class="c-form__item">
                        <label for="login-password" class="c-form-lavel">パスワード</label>
                        <input id="login-password" type="password" class="c-input" v-model="loginFrom.password">
                      </div>
                      <div class="c-form__action">
                        <div class="c-form__action c-form__action__item">
                          <button type="submit" class="c-btn c-btn__login">ログインする</button>
                        </div>
                        <div class="c-btn-reminder">
                          <router-link to="/reminder">パスワードを忘れた方はこちら</router-link>
                        </div>
                      </div>
                  </form>
                  <hr class="u-form__line">
                  <div class="u-social__item">
                    <a href="" class="c-btn c-btn__twitter">Twitterログインする</a>
                  </div>
              </div><!-- c-form__container -->
          </div><!-- l-card__container -->
      </section><!-- l-main__auth -->
  </div><!-- l-wrapper__login -->
</template>

<script>

import { mapState } from 'vuex'

export default {
  data (){
    return {
        loginFrom: 
          {
            email:'',
            password:''
          }
    }

  },
  computed: {
    isLogin(){
      return this.$store.getters['auth/check']
    },
    // 通信失敗の場合（apiStatusがfalse）の場合にはトップページの移動処理を行わない
    apiStatus(){
    // authモジュールのapiStatusを参照
    return this.$store.state.auth.apiStatus
    },
    // ログイン時にエラーがった場合にメッセージを表示する
    loginErrors(){
    return this.$store.state.auth.loginErrorMessages
    }
  },
  methods: {
    // authストアのloginアクションを呼び出す
    async login(){
      await this.$store.dispatch('auth/login', this.loginFrom);
      if(this.apiStatus){
        // 通信が成功（apiStatusがtureの場合）したら移動する
        this.$router.push('/tasklist');
      }
      // this.$router.push('/tasklist');
    }
  }
}
</script>

<style>

</style>