<template>
    <div class="l-wrapper l-wrapper--login">
        <section class="l-main__auth">
            <div class="c-logo__header">
                <router-link to="/">
                    <img src="../../../img/logo.png" alt="logo" class="c-logo">
                </router-link>
            </div>
            <div class="l-card__container">
                <div class="l-card__content">
                    <div class="p-card__container">
                        <p class="p-card__title">ログイン画面</p>
                        <hr class="u-form__line">
                    </div>
                </div>
                <!-- end content -->
                <div class="c-form__container">
                    <form @submit.prevent="login">
                        <div class="c-form__item">
                            <label for="login-email" class="c-form-lavel">メールアドレス</label>
                            <!-- バリデーションエラー -->
                            <div v-if="loginErrors" class="errors">
                                <ul v-if="loginErrors.email">
                                    <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <input id="login-email" type="text" class="c-input" v-model="loginFrom.email">
                        </div>
                        <!-- end c-form__item -->
                        <div class="c-form__item">
                            <label for="login-password" class="c-form-lavel">パスワード</label>
                            <!-- バリデーションエラー -->
                            <div v-if="loginErrors" class="errors">
                                <ul v-if="loginErrors.password">
                                    <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <input id="login-password" type="password" class="c-input" v-model="loginFrom.password">
                        </div>
                        <!-- end c-form__item -->
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
                        <button class="c-btn c-btn__twitter" @click="twitterlogin">Twitterログインする</button>
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
    // isLogin(){
    //   return this.$store.getters['auth/check']
    // },
    // // 通信失敗の場合（apiStatusがfalse）の場合にはトップページの移動処理を行わない
    // apiStatus(){
    // // authモジュールのapiStatusを参照
    // return this.$store.state.auth.apiStatus
    // },
    // // ログイン時にエラーがった場合にメッセージを表示する
    // loginErrors(){
    // return this.$store.state.auth.loginErrorMessages
    // }
    // ...mapStateを使った書き方
    ...mapState({
      isLogin: state => getters['auth/check'],
      apiStatus: state => state.auth.apiStatus, // ここもゲッターにできる？
      loginErrors: state => state.auth.loginErrorMessages
    })
  },
  methods: {
    // authストアのloginアクションを呼び出す
    async login(){
      await this.$store.dispatch('auth/login', this.loginFrom);
      if(this.apiStatus){
        // 通信が成功（apiStatusがtureの場合）したら移動する
        this.$router.push('/tasklist');
      }
    },
    clearError(){
      this.$store.commit('auth/setLoginErrorMessages', null)
    },
    async twitterlogin(){
      await axios.get('/api/twitter')
      .then(response => {
        const URL = response.data.redirect_url
        window.location = URL
      }).
      catch(error => error.response || error)
    }
  },
    created(){
    // createdライフサイクルフックで、表示が残っていたバリデーションメッセージを消す
    this.clearError()
  }
}
</script>
<style>

</style>