<template>
  <header class="l-header__top">
  <div class="l-header__nav l-header__container">
    <div class="c-logo__header c-logo__clear-margin">
     <router-link to="/"><img src="../../img/log-top.png" alt="logo" class="c-logo-ind__header"></router-link>
    </div>
    <nav>
        <ul v-if="apiStatus">
          <li v-if="isLogin"><i class="fas fa-user-tie p-header p-header--icon"></i><span class="p-header p-header--title">{{ username }}</span></li>
          <li><router-link to="register" class="c-btn c-header__signin">マイページ</router-link></li>
          <li><div @click="logout" class="c-btn c-header__login">ログアウト</div></li>
        </ul>
        <ul v-else>
          <li v-if="isLogin"><i class="fas fa-user-tie p-header p-header--icon"></i><span class="p-header p-header--title">{{ username }}</span></li>
          <li><router-link to="register" class="c-btn c-header__signin">新規登録</router-link></li>
          <li><router-link to="login" class="c-btn c-header__login">ログイン</router-link></li>
        </ul>
    </nav>
  </div>
  </header>
</template>

<script>
export default {
    date(){
      return {
    
      }
    },
    computed: {
      isLogin(){
      return this.$store.getters['auth/check']
      },
      username(){
        return this.$store.getters['auth/username']
      },
      apiStatus(){
      // authモジュールのapiStatusを参照
      return this.$store.state.auth.apiStatus
      },
    },
    methods: {
      async logout(){
        await this.$store.dispatch('auth/logout')
        if(this.apiStatus){
        // 通信が成功（apiStatusがtureの場合）したら移動する
        this.$router.push('/login');
      }
      }
    }
}
</script>

<style>

</style>