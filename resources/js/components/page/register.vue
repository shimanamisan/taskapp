<template>
  <div class="l-wrapper">
  <section class="l-main__auth">
    <div class="c-logo__header">
      <router-link to="/"><img src="../../../img/logo.png" alt="logo" class="c-logo"></router-link>
    </div>
    <div class="l-card__container">
        <div class="p-card__container">
          <p class="p-card__title">新規ユーザー登録</p>
        </div>
        <hr class="u-form__line">
        <div class="c-form__container">
            <form @submit.prevent="register">
                <div class="c-form__item">
                  <label for="" class="c-form-lavel">ニックネーム</label>
                  <input type="text" class="c-input" v-model="registerForm.name">
                </div>
                <div class="c-form__item">
                  <label for="" class="c-form-lavel">メールアドレス</label>
                  <input type="text" class="c-input" v-model="registerForm.email">
                </div>
                <div class="c-form__item">
                  <label for="" class="c-form-lavel">パスワード</label>
                  <input type="password" class="c-input" v-model="registerForm.password">
                </div>
                <div class="c-form__item">
                  <label for="" class="c-form-lavel">パスワード再入力</label>
                  <input type="password" class="c-input" v-model="registerForm.password_confirmation">
                </div>
                <div class=""> 
                  「<a href="">利用規約</a>」利用規約を必ずご確認ください
                </div>
                <div class="c-form__action c-form__action__item">
                  <button type="submit" class="c-btn c-btn__signin">利用規約に同意して新規登録</button>
                </div>
            </form>
      </div>
    </div><!-- l-card__container -->
    <div class="u-redirect__login">
      既に登録済みの方は<router-link to="/login">こちら➡</router-link>
    </div>
  </section><!-- l-main__auth -->
</div><!-- l-wrapper__login -->
</template>

<script>
export default {
  data (){
    return {
        registerForm:
          {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
          }
    }
  },
  methods: {
    async register(){

      // await:非同期なアクションの処理が完了するのを待ってから（難しく言うと Promise の解決を待ってから）ページ遷移する
      // authストアのregisterアクションを呼び出す
      await this.$store.dispatch('auth/register', this.registerForm)

       if (this.apiStatus) {
        // トップページに移動する
        this.$router.push('/')
      }      
    },
    
  }
}
</script>

<style>

</style>